@extends('venture-dashboard::layouts.app')

@section('content')
    <main>
        <h1 class="text-2xl text-gray-800 tracking-tight mb-3">
            {{ __('Current Workflows') }}
        </h1>

        <div class="bg-white rounded-lg shadow pt-1 pb-2">
            <table class="w-full">
                <thead class="text-sm text-gray-600">
                <tr class="border-b border-gray-300">
                    <th class="text-left pl-6 pr-2 pt-2 pb-2 font-normal">{{ __('ID') }}</th>
                    <th class="text-left px-2 pt-2 pb-2 font-normal">{{ __('Name') }}</th>
                    <th class="text-left px-2 pt-2 pb-2 font-normal text-right">{{ __('Progress') }}</th>
                    <th class="text-left pl-2 pr-6 pt-2 pb-2 font-normal">{{ __('Started at') }}</th>
                </tr>
                </thead>

                <tbody>
                @foreach ($workflows as $workflow)
                    <tr class="text-sm transition duration-300 hover:bg-gray-100 cursor-pointer text-gray-800">
                        <td class="pl-6 pr-2 py-2">{{ $workflow->id }}</td>
                        <td class="px-2 py-2">
                            <a
                                href="{{ route('venture.dashboard.workflows.show', $workflow) }}"
                                class="text-laravel"
                            >
                                {{ $workflow->name }}
                            </a>
                        </td>
                        <td class="px-2 py-2 text-right">
                            {{ number_format(($workflow->jobs_processed / $workflow->job_count) * 100) }} %
                        </td>
                        <td class="pl-2 pr-6 py-2">{{ $workflow->created_at->format('Y-m-d H:i') }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </main>
@endsection
