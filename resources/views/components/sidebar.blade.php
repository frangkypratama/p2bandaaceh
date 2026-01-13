<div class="fixed h-screen w-64 bg-gray-800 text-white">
    <div class="flex items-center justify-center h-20 shadow-md">
        <h1 class="text-2xl font-bold">SBP App</h1>
    </div>
    <nav class="mt-10">
        <a href="/dashboard" class="flex items-center py-4 px-6 text-gray-300 hover:bg-gray-700 hover:text-white">
            <svg class="h-6 w-6 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
            </svg>
            Dashboard
        </a>
        <a href="{{ route('sbp.create') }}" class="flex items-center py-4 px-6 text-gray-300 hover:bg-gray-700 hover:text-white">
            <svg class="h-6 w-6 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
            </svg>
            Input SBP
        </a>
        <a href="{{ route('sbp.index') }}" class="flex items-center py-4 px-6 text-gray-300 hover:bg-gray-700 hover:text-white">
            <svg class="h-6 w-6 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
            </svg>
            Data SBP
        </a>
    </nav>
</div>
