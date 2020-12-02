@extends('venture-dashboard::layouts.app')

@section('content')
    <h1 class="text-2xl text-gray-900 mb-2">{{ $workflow->name }}</h1>

    <section class="bg-white bg-opacity-25 rounded-lg shadow mb-6" style="height: 450px">
        <workflow-graph :graph="{{ json_encode($graph) }}"></workflow-graph>
    </section>

    <section>
        <h2 class="text-xl text-gray-900 mb-2">Jobs</h2>

        <div class="bg-white rounded-lg shadow">
            <job-table :jobs="{{ json_encode($workflow->jobs) }}"></job-table>
        </div>
    </section>
@endsection
