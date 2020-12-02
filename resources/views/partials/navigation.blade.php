<div class="flex flex-col">
    <a href="{{ route('venture.dashboard.running') }}"
       class="text-sm transition duration-150 hover:text-laravel py-2 {{ active('venture.dashboard.running', 'text-laravel', 'text-gray-700') }}"
    >
        <i class="fas fa-project-diagram w-4 mr-1"></i>
        Running Workflows
    </a>

    <a href="{{ route('venture.dashboard.finished') }}"
       class="text-sm transition duration-150 hover:text-laravel py-2 {{ active('venture.dashboard.finished', 'text-laravel', 'text-gray-700') }}"
    >
        <i class="fas fa-check w-4 mr-1"></i>
        Finished Workflows
    </a>

    <a href="{{ route('venture.dashboard.failed') }}"
       class="text-sm transition duration-150 hover:text-laravel py-2 {{ active('venture.dashboard.failed', 'text-laravel', 'text-gray-700') }}"
    >
            <i class="fas fa-times w-4 mr-1"></i>
            Failed Workflows
    </a>
</div>
