/**
 * PhotoUploadField - komponen upload + kompresi foto sisi client (reusable).
 *
 * Tidak butuh dependency eksternal, kompresi pakai Canvas API native.
 * Class markup default (upload-dropzone, upload-tile, dst) mengikuti CSS yang
 * sudah ada di halaman LPT - konsumen lain bisa override lewat opsi classNames.
 *
 * Contoh pakai:
 *   const upload = new PhotoUploadField({
 *     input: '#photos',
 *     dropzone: '#uploadDropzone',
 *     previewContainer: '#photoGrid',
 *     clearAllButton: '#clearAllBtn',
 *     lightbox: '#lightbox',
 *     multiple: true,
 *     existingPhotos: [{ id: 1, url: '/lpt/photos/1', name: 'foto1.jpg' }],
 *     deletedInputsContainer: '#deleted_photos_container',
 *     deletedInputName: 'deleted_photos[]',
 *     compress: { maxWidth: 1200, maxHeight: 1200, quality: 0.7, thresholdKB: 300 },
 *     onProgress: ({ index, total, file }) => { ... },
 *     onCompressStart: (total) => { ... },
 *     onCompressEnd: () => { ... },
 *     onChange: (state) => { ... },
 *   });
 */
(function (global) {
    'use strict';

    function resolveEl(target) {
        if (!target) return null;
        return typeof target === 'string' ? document.querySelector(target) : target;
    }

    function formatSize(bytes) {
        if (bytes < 1024) return bytes + ' B';
        if (bytes < 1024 * 1024) return (bytes / 1024).toFixed(1) + ' KB';
        return (bytes / (1024 * 1024)).toFixed(2) + ' MB';
    }

    function compressImage(file, opts) {
        return new Promise((resolve) => {
            if (!file.type.startsWith('image/') || file.type === 'image/gif') {
                resolve(file);
                return;
            }
            const objectUrl = URL.createObjectURL(file);
            const img = new Image();
            img.onload = () => {
                const ratio = Math.min(1, opts.maxWidth / img.width, opts.maxHeight / img.height);
                const width = Math.round(img.width * ratio);
                const height = Math.round(img.height * ratio);
                const canvas = document.createElement('canvas');
                canvas.width = width;
                canvas.height = height;
                canvas.getContext('2d').drawImage(img, 0, 0, width, height);
                canvas.toBlob((blob) => {
                    URL.revokeObjectURL(objectUrl);
                    if (!blob || blob.size >= file.size) {
                        resolve(file);
                        return;
                    }
                    const newName = file.name.replace(/\.[^./\\]+$/, '') + '.jpg';
                    const compressed = new File([blob], newName, { type: 'image/jpeg', lastModified: Date.now() });
                    compressed._compressed = true;
                    resolve(compressed);
                }, 'image/jpeg', opts.quality);
            };
            img.onerror = () => {
                URL.revokeObjectURL(objectUrl);
                resolve(file);
            };
            img.src = objectUrl;
        });
    }

    class PhotoUploadField {
        constructor(options) {
            this.input = resolveEl(options.input);
            if (!this.input) {
                throw new Error('PhotoUploadField: elemen input file tidak ditemukan.');
            }
            this.dropzone = resolveEl(options.dropzone) || this.input;
            this.previewContainer = resolveEl(options.previewContainer);
            this.deletedInputsContainer = resolveEl(options.deletedInputsContainer);
            this.clearAllButton = resolveEl(options.clearAllButton);

            this.multiple = options.multiple !== undefined ? !!options.multiple : true;
            this.deletedInputName = options.deletedInputName || 'deleted_photos[]';
            this.dragoverClass = options.dragoverClass || 'dragover';

            this.compressOpts = Object.assign({
                enabled: true,
                maxWidth: 1200,
                maxHeight: 1200,
                quality: 0.7,
                thresholdKB: 300,
            }, options.compress || {});

            this.onChange = typeof options.onChange === 'function' ? options.onChange : () => {};
            this.onProgress = typeof options.onProgress === 'function' ? options.onProgress : null;
            this.onCompressStart = typeof options.onCompressStart === 'function' ? options.onCompressStart : null;
            this.onCompressEnd = typeof options.onCompressEnd === 'function' ? options.onCompressEnd : null;

            this.existingPhotos = (options.existingPhotos || []).slice();
            this.deletedIds = [];
            this.newFiles = [];

            this._bindDropzone();
            this._bindInputChange();
            this._bindPreviewClicks();
            if (options.lightbox !== false) {
                this._setupLightbox(options.lightbox === true || options.lightbox === undefined ? null : options.lightbox);
            }
            if (this.clearAllButton) {
                this.clearAllButton.addEventListener('click', () => this.clearNewFiles());
            }

            this.render();
        }

        // ---- API publik ----

        getNewFiles() {
            return this.newFiles;
        }

        getDeletedIds() {
            return this.deletedIds;
        }

        getRemainingExisting() {
            return this.existingPhotos;
        }

        clearNewFiles() {
            this.newFiles = [];
            this._syncInputFiles();
            this.render();
            this.onChange(this._state());
        }

        // ---- Internal ----

        _state() {
            return {
                newFiles: this.newFiles,
                deletedIds: this.deletedIds,
                existingPhotos: this.existingPhotos,
            };
        }

        _bindDropzone() {
            ['dragenter', 'dragover'].forEach((evt) =>
                this.dropzone.addEventListener(evt, (e) => {
                    e.preventDefault();
                    this.dropzone.classList.add(this.dragoverClass);
                })
            );
            ['dragleave', 'dragend'].forEach((evt) =>
                this.dropzone.addEventListener(evt, () => this.dropzone.classList.remove(this.dragoverClass))
            );
            this.dropzone.addEventListener('drop', (e) => {
                e.preventDefault();
                this.dropzone.classList.remove(this.dragoverClass);
                const files = e.dataTransfer && e.dataTransfer.files;
                if (files && files.length) {
                    this._handleFiles(Array.from(files));
                }
            });
            // Jika input tidak berada di dalam dropzone (mis. input tersembunyi terpisah),
            // klik dropzone perlu diteruskan manual untuk membuka dialog file.
            this.dropzone.addEventListener('click', () => {
                if (!this.dropzone.contains(this.input)) {
                    this.input.click();
                }
            });
        }

        _bindInputChange() {
            this.input.addEventListener('change', () => {
                const files = Array.from(this.input.files || []);
                if (files.length) this._handleFiles(files);
            });
        }

        _bindPreviewClicks() {
            if (!this.previewContainer) return;
            this.previewContainer.addEventListener('click', (e) => {
                const delBtn = e.target.closest('[data-photo-del]');
                if (delBtn) {
                    const id = delBtn.getAttribute('data-photo-id');
                    const idx = delBtn.getAttribute('data-photo-index');
                    if (id) {
                        this._markExistingDeleted(id);
                    } else if (idx !== null) {
                        this.newFiles.splice(parseInt(idx, 10), 1);
                        this._syncInputFiles();
                    }
                    this.render();
                    this.onChange(this._state());
                    return;
                }
                const img = e.target.closest('[data-photo-img]');
                if (img && this.lightboxEl) {
                    this._openLightbox(img.getAttribute('data-photo-url'));
                }
            });
        }

        _markExistingDeleted(id) {
            this.deletedIds.push(id);
            this.existingPhotos = this.existingPhotos.filter((p) => String(p.id) !== String(id));
            if (this.deletedInputsContainer) {
                const hidden = document.createElement('input');
                hidden.type = 'hidden';
                hidden.name = this.deletedInputName;
                hidden.value = id;
                this.deletedInputsContainer.appendChild(hidden);
            }
        }

        async _handleFiles(files) {
            if (!this.multiple) {
                this.existingPhotos.forEach((p) => this._markExistingDeleted(p.id));
                this.newFiles = [];
                files = files.slice(0, 1);
            }

            if (this.onCompressStart) this.onCompressStart(files.length);

            for (let i = 0; i < files.length; i++) {
                const file = files[i];
                if (this.onProgress) this.onProgress({ index: i, total: files.length, file });

                const sizeKB = file.size / 1024;
                if (this.compressOpts.enabled && sizeKB > this.compressOpts.thresholdKB) {
                    try {
                        this.newFiles.push(await compressImage(file, this.compressOpts));
                    } catch (err) {
                        console.error('PhotoUploadField: gagal kompres', file.name, err);
                        this.newFiles.push(file);
                    }
                } else {
                    this.newFiles.push(file);
                }
            }

            if (this.onCompressEnd) this.onCompressEnd();

            this._syncInputFiles();
            this.render();
            this.onChange(this._state());
        }

        _syncInputFiles() {
            const dt = new DataTransfer();
            this.newFiles.forEach((f) => dt.items.add(f));
            this.input.files = dt.files;
        }

        _setupLightbox(existingTarget) {
            if (existingTarget) {
                this.lightboxEl = resolveEl(existingTarget);
            } else {
                this.lightboxEl = document.createElement('div');
                this.lightboxEl.className = 'upload-lightbox';
                this.lightboxEl.innerHTML = '<button type="button" class="upload-lightbox-close">&times;</button><img alt="preview">';
                document.body.appendChild(this.lightboxEl);
            }
            if (!this.lightboxEl) return;

            const closeBtn = this.lightboxEl.querySelector('.upload-lightbox-close, [data-lightbox-close]');
            if (closeBtn) closeBtn.addEventListener('click', () => this.lightboxEl.classList.remove('active'));
            this.lightboxEl.addEventListener('click', (e) => {
                if (e.target === this.lightboxEl) this.lightboxEl.classList.remove('active');
            });
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') this.lightboxEl.classList.remove('active');
            });
        }

        _openLightbox(url) {
            if (!url || !this.lightboxEl) return;
            const img = this.lightboxEl.querySelector('img');
            if (img) img.src = url;
            this.lightboxEl.classList.add('active');
        }

        render() {
            if (!this.previewContainer) return;
            this.previewContainer.innerHTML = '';

            this.existingPhotos.forEach((photo) => {
                const tile = document.createElement('div');
                tile.className = 'upload-tile existing-photo';
                tile.innerHTML = `
                    <button type="button" class="upload-tile-del" data-photo-del data-photo-id="${photo.id}" title="Hapus">&times;</button>
                    <span class="upload-tile-badge existing">Sudah Tersimpan</span>
                    <img src="${photo.url}" class="upload-tile-img" data-photo-img data-photo-url="${photo.url}" alt="${photo.name || ''}">
                    <div class="upload-tile-meta"></div>
                `;
                this.previewContainer.appendChild(tile);
            });

            this.newFiles.forEach((file, idx) => {
                const url = URL.createObjectURL(file);
                const tile = document.createElement('div');
                tile.className = 'upload-tile';
                tile.innerHTML = `
                    <button type="button" class="upload-tile-del" data-photo-del data-photo-index="${idx}" title="Hapus">&times;</button>
                    ${file._compressed ? '<span class="upload-tile-badge">Dikompres</span>' : ''}
                    <img src="${url}" class="upload-tile-img" data-photo-img data-photo-url="${url}" alt="${file.name}">
                    <div class="upload-tile-meta">
                        <span class="upload-tile-name" title="${file.name}">${file.name}</span>
                        <span class="upload-tile-size">${formatSize(file.size)}</span>
                    </div>
                `;
                this.previewContainer.appendChild(tile);
            });
        }
    }

    global.PhotoUploadField = PhotoUploadField;
})(window);
