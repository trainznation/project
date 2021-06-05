@extends("layouts.app")

@section("bread")
    {{ Breadcrumbs::render('dashboard') }}
@endsection

@section("content")
    <div class="row g-6 g-xl-9">
        <div class="col-lg-12 col-xxl-12">
            <!--begin::Card-->
            <div class="card h-100">
                <!--begin::Card body-->
                <div class="card-body p-9">
                    <!--begin::Heading-->
                    <div class="fs-2hx fw-bolder" id="count_project">{{ $user->projects()->count() }}</div>
                    <div class="fs-4 fw-bold text-gray-400 mb-7">Projets Totales</div>
                    <!--end::Heading-->
                    <!--begin::Wrapper-->
                    <div class="d-flex flex-wrap">
                        <!--begin::Chart-->
                        <div class="d-flex flex-center h-200px w-300px me-9 mb-5">
                            <canvas id="kt_project_list_chart" width="100" height="100" style="display: block; box-sizing: border-box; height: 100px; width: 100px;"></canvas>
                        </div>
                        <!--end::Chart-->
                        <!--begin::Labels-->
                        <div class="d-flex flex-column justify-content-center flex-row-fluid pe-11 mb-5">
                            <!--begin::Label-->
                            <div class="d-flex fs-6 fw-bold align-items-center mb-3">
                                <div class="bullet bg-warning me-3"></div>
                                <div class="text-gray-400">En cours</div>
                                <div class="ms-auto fw-bolder text-gray-700" id="project_progress" data-count="{{ $user->projects()->where('state', 0)->count() }}">{{ $user->projects()->where('state', 0)->count() }}</div>
                            </div>
                            <!--end::Label-->
                            <!--begin::Label-->
                            <div class="d-flex fs-6 fw-bold align-items-center mb-3">
                                <div class="bullet bg-success me-3"></div>
                                <div class="text-gray-400">Terminer</div>
                                <div class="ms-auto fw-bolder text-gray-700" id="project_finish" data-count="{{ $user->projects()->where('state', 1)->count() }}">{{ $user->projects()->where('state', 1)->count() }}</div>
                            </div>
                            <!--end::Label-->
                            <!--begin::Label-->
                            <div class="d-flex fs-6 fw-bold align-items-center mb-3">
                                <div class="bullet bg-danger me-3"></div>
                                <div class="text-gray-400">Annuler</div>
                                <div class="ms-auto fw-bolder text-gray-700" id="project_trash" data-count="{{ $user->projects()->where('state', 2)->count() }}">{{ $user->projects()->where('state', 2)->count() }}</div>
                            </div>
                            <!--end::Label-->
                            <div class="d-flex fs-6 fw-bold align-items-center">
                                <div class="bullet bg-info me-3"></div>
                                <div class="text-gray-400">En attente</div>
                                <div class="ms-auto fw-bolder text-gray-700" id="project_waiting" data-count="{{ $user->projects()->where('state', 3)->count() }}">{{ $user->projects()->where('state', 3)->count() }}</div>
                            </div>
                        </div>
                        <!--end::Labels-->
                    </div>
                    <!--end::Wrapper-->
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Card-->
        </div>
    </div>
    <div class="d-flex flex-wrap flex-stack my-5">
        <!--begin::Heading-->
        <h2 class="fs-2 fw-bold my-2">Projets
            <span class="fs-6 text-gray-400 ms-1">par status</span></h2>
        <!--end::Heading-->
    </div>
    <div class="row g-6 g-xl-9" id="showProject">
        <!--begin::Col-->
        @foreach($user->projects()->orderBy('time_start', 'asc')->limit(9)->get() as $project)
            <div class="col-md-6 col-xl-4">
            <!--begin::Card-->
            <a href="#" class="card border border-2 border-gray-300 border-hover">
                <!--begin::Card header-->
                <div class="card-header border-0 pt-9">
                    <!--begin::Card Title-->
                    <div class="card-title m-0">
                        <!--begin::Avatar-->
                        <div class="symbol symbol-50px w-50px bg-light">
                            <div class="symbol-label fs-2 fw-bold text-success">{{ \Illuminate\Support\Str::limit($project->title, 1, '') }}</div>
                        </div>
                        <!--end::Avatar-->
                    </div>
                    <!--end::Car Title-->
                    <!--begin::Card toolbar-->
                    <div class="card-toolbar">
                        {!! stateLabelProject($project->state) !!}
                    </div>
                    <!--end::Card toolbar-->
                </div>
                <!--end:: Card header-->
                <!--begin:: Card body-->
                <div class="card-body p-9">
                    <!--begin::Name-->
                    <div class="fs-3 fw-bolder text-dark">{{ $project->title }}</div>
                    <!--end::Name-->
                    <!--begin::Description-->
                    <p class="text-gray-400 fw-bold fs-5 mt-1 mb-7">{{ \Illuminate\Support\Str::limit($project->short_description, 100, '...') }}</p>
                    <!--end::Description-->
                    <!--begin::Info-->
                    <div class="d-flex flex-wrap mb-5">
                        <!--begin::Due-->
                        <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-7 mb-3">
                            <div class="fs-6 text-gray-800 fw-bolder">{{ $project->time_start->format("d/m/Y à H:i") }}</div>
                            <div class="fw-bold text-gray-400">Date de début</div>
                        </div>
                        <!--end::Due-->
                    </div>
                    <!--end::Info-->
                    <!--begin::Progress-->
                    {!! stateProgressStateTask($project->id) !!}
                    <!--end::Progress-->
                    <!--begin::Users-->
                    <div class="symbol-group symbol-hover">
                        <!--begin::User-->
                        @foreach($project->users as $user)
                        <div class="symbol symbol-35px symbol-circle" data-bs-toggle="tooltip" title="{{ $user->name }}">
                            <div class="symbol-label fs-2 fw-bold text-danger">{{ \Illuminate\Support\Str::limit($user->name, 1, '') }}</div>
                        </div>
                        @endforeach
                        <!--begin::User-->
                    </div>
                    <!--end::Users-->
                </div>
                <!--end:: Card body-->
            </a>
            <!--end::Card-->
        </div>
        @endforeach
        <!--end::Col-->
    </div>
@endsection

@section("scripts")
    <script type="text/javascript" src="js/dashboard.js"></script>
@endsection
