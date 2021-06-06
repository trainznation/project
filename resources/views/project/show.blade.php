@extends("layouts.app")

@section("styles")

@endsection

@section("bread")
    {{ Breadcrumbs::render('project_show', $project) }}
@endsection

@section("content")
    <div class="card mb-6 mb-xl-9">
        <div class="card-body pt-9 pb-0">
            <!--begin::Details-->
            <div class="d-flex flex-wrap flex-sm-nowrap mb-6">
                <!--begin::Image-->
                <div class="d-flex flex-center flex-shrink-0 bg-light rounded w-100px h-100px w-lg-150px h-lg-150px me-7 mb-4">
                    @if(Storage::disk('public')->exists('files/projects/logo/'.$project->id.'.png') == true)
                        <img class="mw-50px mw-lg-75px" src="/storage/files/projects/logo/{{ $project->id }}.png" alt="image" />
                    @else
                        <div class="symbol symbol-100px">
                            <div class="symbol-label fs-2 fw-bold text-success">{{ \Illuminate\Support\Str::limit($project->title, 2, '') }}</div>
                        </div>
                    @endif
                </div>
                <!--end::Image-->
                <!--begin::Wrapper-->
                <div class="flex-grow-1">
                    <!--begin::Head-->
                    <div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
                        <!--begin::Details-->
                        <div class="d-flex flex-column">
                            <!--begin::Status-->
                            <div class="d-flex align-items-center mb-1">
                                <a href="#" class="text-gray-800 text-hover-primary fs-2 fw-bolder me-3">{{ $project->title }}</a>
                                {!! stateLabelProject($project->state) !!}
                            </div>
                            <!--end::Status-->
                            <!--begin::Description-->
                            <div class="d-flex flex-wrap fw-bold mb-4 fs-5 text-gray-400">{{ \Illuminate\Support\Str::limit($project->short_description, 50) }}</div>
                            <!--end::Description-->
                        </div>
                        <!--end::Details-->
                        <!--begin::Actions-->
                        <div class="d-flex mb-4">
                            <a href="#" class="btn btn-sm btn-bg-light btn-active-color-primary me-3" data-bs-toggle="modal" data-bs-target="#kt_modal_users_search">Ajouter utilisateur</a>
                            <a href="#" class="btn btn-sm btn-primary me-3" data-bs-toggle="modal" data-bs-target="#kt_modal_new_target">Ajouter une tache</a>
                        </div>
                        <!--end::Actions-->
                    </div>
                    <!--end::Head-->
                    <!--begin::Info-->
                    <div class="d-flex flex-wrap justify-content-start">
                        <!--begin::Stats-->
                        <div class="d-flex flex-wrap">
                            <!--begin::Stat-->
                            <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                <!--begin::Number-->
                                <div class="d-flex align-items-center">
                                    <div class="fs-4 fw-bolder">{{ $project->time_start->format('d/m/Y') }}</div>
                                </div>
                                <!--end::Number-->
                                <!--begin::Label-->
                                <div class="fw-bold fs-6 text-gray-400">Date de début</div>
                                <!--end::Label-->
                            </div>
                            <!--end::Stat-->
                            <!--begin::Stat-->
                            <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                <!--begin::Number-->
                                <div class="d-flex align-items-center">
                                    <!--begin::Svg Icon | path: icons/duotone/Navigation/Arrow-down.svg-->
                                    <span class="svg-icon svg-icon-3 svg-icon-danger me-2">
										<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
											<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
												<polygon points="0 0 24 0 24 24 0 24" />
												<rect fill="#000000" opacity="0.5" x="11" y="5" width="2" height="14" rx="1" />
												<path d="M6.70710678,18.7071068 C6.31658249,19.0976311 5.68341751,19.0976311 5.29289322,18.7071068 C4.90236893,18.3165825 4.90236893,17.6834175 5.29289322,17.2928932 L11.2928932,11.2928932 C11.6714722,10.9143143 12.2810586,10.9010687 12.6757246,11.2628459 L18.6757246,16.7628459 C19.0828436,17.1360383 19.1103465,17.7686056 18.7371541,18.1757246 C18.3639617,18.5828436 17.7313944,18.6103465 17.3242754,18.2371541 L12.0300757,13.3841378 L6.70710678,18.7071068 Z" fill="#000000" fill-rule="nonzero" transform="translate(12.000003, 14.999999) scale(1, -1) translate(-12.000003, -14.999999)" />
											</g>
										</svg>
									</span>
                                    <!--end::Svg Icon-->
                                    <div class="fs-4 fw-bolder" data-kt-countup="true" data-kt-countup-value="{{ $project->tasks()->where('state', 0)->count()}}">0</div>
                                </div>
                                <!--end::Number-->
                                <!--begin::Label-->
                                <div class="fw-bold fs-6 text-gray-400">Taches ouvertes</div>
                                <!--end::Label-->
                            </div>
                            <!--end::Stat-->
                        </div>
                        <!--end::Stats-->
                        <!--begin::Users-->
                        <div class="symbol-group symbol-hover mb-3">
                            <!--begin::User-->
                            @foreach($project->users()->limit(5)->get() as $user)
                                <div class="symbol symbol-35px symbol-circle" data-bs-toggle="tooltip" title="{{ $user->name }}">
                                    <span class="symbol-label bg-warning text-inverse-warning fw-bolder">{{ \Illuminate\Support\Str::limit($user->name, 2, '') }}</span>
                                </div>
                            @endforeach
                            <!--end::User-->
                            <!--begin::All users-->
                            @if($project->users()->count() > 5)
                                <a href="#" class="symbol symbol-35px symbol-circle" data-bs-toggle="modal" data-bs-target="#kt_modal_view_users">
                                    <span class="symbol-label bg-dark text-white fs-8 fw-bolder" data-bs-toggle="tooltip" data-bs-trigger="hover" title="Voir tous les utilisateurs">+ {{ $project->users()->count() -5 }}</span>
                                </a>
                            @endif
                            <!--end::All users-->
                        </div>
                        <!--end::Users-->
                    </div>
                    <!--end::Info-->
                </div>
                <!--end::Wrapper-->
            </div>
            <!--end::Details-->
            <div class="separator"></div>
            <!--begin::Nav wrapper-->
            <div class="d-flex overflow-auto h-55px">
                <!--begin::Nav links-->
                <ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bolder flex-nowrap">
                    <!--begin::Nav item-->
                    <li class="nav-item">
                        <a class="nav-link text-active-primary me-6 active" href="{{ route('project.show', $project->id) }}">Générale</a>
                    </li>
                    <!--end::Nav item-->
                    <!--begin::Nav item-->
                    <li class="nav-item">
                        <a class="nav-link text-active-primary me-6" href="pages/projects/targets.html">Tâches</a>
                    </li>
                    <!--end::Nav item-->
                    <!--begin::Nav item-->
                    <li class="nav-item">
                        <a class="nav-link text-active-primary me-6" href="pages/projects/budget.html">Fichiers</a>
                    </li>
                    <!--end::Nav item-->
                    <!--begin::Nav item-->
                    <li class="nav-item">
                        <a class="nav-link text-active-primary me-6" href="pages/projects/users.html">Activités</a>
                    </li>
                    <!--end::Nav item-->
                    <!--begin::Nav item-->
                    <li class="nav-item">
                        <a class="nav-link text-active-primary me-6" href="pages/projects/files.html">Conversations</a>
                    </li>
                    <!--end::Nav item-->
                    <!--begin::Nav item-->
                    <li class="nav-item">
                        <a class="nav-link text-active-primary me-6" href="pages/projects/activity.html">Configurations</a>
                    </li>
                    <!--end::Nav item-->
                </ul>
                <!--end::Nav links-->
            </div>
            <!--end::Nav wrapper-->
        </div>
    </div>

    <div class="card mb-6">
        <div class="card-body">
            <i>{{ $project->short_description }}</i><br><br>
            <p>{!! $project->description !!}</p>
        </div>
    </div>

    <div class="row g-6 g-xl-9">
        <!--begin::Col-->
        <div class="col-lg-6">
            <!--begin::Summary-->
            <div class="card card-flush h-lg-100">
                <!--begin::Card header-->
                <div class="card-header mt-6">
                    <!--begin::Card title-->
                    <div class="card-title flex-column">
                        <h3 class="fw-bolder mb-1">Résumé des tâches</h3>
                        <div class="fs-6 fw-bold text-gray-400">{{ $project->tasks()->where('state', 0)->count() }} {{ \Illuminate\Support\Str::plural('Tâche', $project->tasks()->where('state', 0)->count()) }} {{ \Illuminate\Support\Str::plural('Ouverte', $project->tasks()->where('state', 0)->count()) }}</div>
                    </div>
                    <!--end::Card title-->
                    <!--begin::Card toolbar-->
                    <div class="card-toolbar">
                        <a href="#" class="btn btn-light btn-sm">Voir les tâches</a>
                    </div>
                    <!--end::Card toolbar-->
                </div>
                <!--end::Card header-->
                <!--begin::Card body-->
                <div class="card-body p-9 pt-5">
                    <!--begin::Wrapper-->
                    <div class="d-flex flex-wrap">
                        <!--begin::Chart-->
                        <div class="position-relative d-flex flex-center h-175px w-175px me-15 mb-7">
                            <canvas id="project_overview_chart" data-project-id="{{ $project->id }}"></canvas>
                        </div>
                        <!--end::Chart-->
                        <!--begin::Labels-->
                        <div class="d-flex flex-column justify-content-center flex-row-fluid pe-11 mb-5">
                            <!--begin::Label-->
                            <div class="d-flex fs-6 fw-bold align-items-center mb-3">
                                <div class="bullet bg-success me-3"></div>
                                <div class="text-gray-400">Ouverte</div>
                                <div class="ms-auto fw-bolder text-gray-700">{{ $project->tasks()->where('state', 0)->count() }}</div>
                            </div>
                            <!--end::Label-->
                            <!--begin::Label-->
                            <div class="d-flex fs-6 fw-bold align-items-center mb-3">
                                <div class="bullet bg-danger me-3"></div>
                                <div class="text-gray-400">Fermer</div>
                                <div class="ms-auto fw-bolder text-gray-700">{{ $project->tasks()->where('state', 1)->count() }}</div>
                            </div>
                            <!--end::Label-->
                        </div>
                        <!--end::Labels-->
                    </div>
                    <!--end::Wrapper-->
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Summary-->
        </div>
        <!--end::Col-->
        <!--begin::Col-->
        <div class="col-lg-6">
            <!--begin::Graph-->
            <div class="card card-flush h-lg-100">
                <!--begin::Card header-->
                <div class="card-header mt-6">
                    <!--begin::Card title-->
                    <div class="card-title flex-column">
                        <h3 class="fw-bolder mb-1">Taches dans le temps</h3>
                        <!--begin::Labels-->
                        <div class="fs-6 d-flex text-gray-400 fs-6 fw-bold">
                            <!--begin::Label-->
                            <div class="d-flex align-items-center me-6">
								<span class="menu-bullet d-flex align-items-center me-2">
									<span class="bullet bg-success"></span>
								</span>Ouvert
                            </div>
                            <!--end::Label-->
                            <!--begin::Label-->
                            <div class="d-flex align-items-center">
								<span class="menu-bullet d-flex align-items-center me-2">
									<span class="bullet bg-primary"></span>
								</span>Fermer
                            </div>
                            <!--end::Label-->
                        </div>
                        <!--end::Labels-->
                    </div>
                    <!--end::Card title-->
                </div>
                <!--end::Card header-->
                <!--begin::Card body-->
                <div class="card-body pt-10 pb-0 px-5">
                    <!--begin::Chart-->
                    <div id="kt_project_overview_graph" class="card-rounded-bottom" style="height: 300px"></div>
                    <!--end::Chart-->
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Graph-->
        </div>
        <!--end::Col-->
        <!--begin::Col-->
        <div class="col-lg-6">
            <!--begin::Card-->
            <div class="card card-flush h-lg-100">
                <!--begin::Card header-->
                <div class="card-header mt-6">
                    <!--begin::Card title-->
                    <div class="card-title flex-column">
                        <h3 class="fw-bolder mb-1">Derniers Fichiers</h3>
                        <div class="fs-6 text-gray-400">{{ $project->files()->count() }} Fichiers Totales, {{ human_filesize($project->files()->sum('size')) }} d'espace utiliser</div>
                    </div>
                    <!--end::Card title-->
                    <!--begin::Card toolbar-->
                    <div class="card-toolbar">
                        <a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">Voir tout</a>
                    </div>
                    <!--end::Card toolbar-->
                </div>
                <!--end::Card header-->
                <!--begin::Card body-->
                <div class="card-body p-9 pt-3">
                    <!--begin::Files-->
                    <div class="d-flex flex-column mb-9">
                        @foreach($project->files()->orderBy('created_at', 'desc')->limit(4)->get() as $file)
                        <!--begin::File-->
                        <div class="d-flex align-items-center mb-5">
                            <!--begin::Icon-->
                            <div class="symbol symbol-30px me-5" data-toggle="tooltip" title="{{ typeFile($file->type) }}">
                                <img alt="Icon" src="/storage/core/icons_files/{{ $file->type }}.png" />
                            </div>
                            <!--end::Icon-->
                            <!--begin::Details-->
                            <div class="fw-bold">
                                <a class="fs-6 fw-bolder text-dark text-hover-primary" href="#">{{ $file->name }}</a>
                                <div class="text-gray-400">{{ $file->created_at->diffForHumans() }}
                                    <a href="#">{{ $file->user->name }}</a></div>
                            </div>
                            <!--end::Details-->
                        </div>
                        <!--end::File-->
                        @endforeach
                    </div>
                    <!--end::Files-->
                </div>
                <!--end::Card body -->
            </div>
            <!--end::Card-->
        </div>
        <!--end::Col-->
        <!--begin::Col-->
        <div class="col-lg-6">
            <!--begin::Tasks-->
            <div class="card card-flush h-lg-100">
                <!--begin::Card header-->
                <div class="card-header mt-6">
                    <!--begin::Card title-->
                    <div class="card-title flex-column">
                        <h3 class="fw-bolder mb-1">Dernières Tâches</h3>
                        <div class="fs-6 text-gray-400">Les 5 dernières tâches ajouter au backlog</div>
                    </div>
                    <!--end::Card title-->
                    <!--begin::Card toolbar-->
                    <div class="card-toolbar">
                        <a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">Voir tout</a>
                    </div>
                    <!--end::Card toolbar-->
                </div>
                <!--end::Card header-->
                <!--begin::Card body-->
                <div class="card-body d-flex flex-column mb-9 p-9 pt-3">
                    @foreach($project->tasks()->orderBy('created_at', 'desc')->limit(5)->get() as $task)
                    <!--begin::Item-->
                    <div class="d-flex align-items-center position-relative mb-7">
                        <!--begin::Label-->
                        <div class="position-absolute top-0 start-0 rounded h-100 bg-{{ stateTask($task->state) }} w-4px"></div>
                        <!--end::Label-->
                        <!--begin::Checkbox-->
                        @if($task->state == 0)
                        <div class="form-check form-check-custom form-check-solid ms-6 me-4">
                            <input class="form-check-input" type="checkbox" value="" />
                        </div>
                        @else
                            <div class="ms-6 me-4">&nbsp;</div>
                        @endif
                        <!--end::Checkbox-->
                        <!--begin::Details-->
                        <div class="fw-bold">
                            <a href="#" class="fs-6 fw-bolder text-gray-900 text-hover-primary">{{ $task->title }}</a>
                            <!--begin::Info-->
                            @if($task->state == 1)
                                <div class="text-gray-400">Terminer {{ $task->created_at->diffForHumans() }}</div>
                            @else
                                <div class="text-gray-400">Ajouter {{ $task->created_at->diffForHumans() }}</div>
                            @endif

                            <!--end::Info-->
                        </div>
                        <!--end::Details-->
                    </div>
                    <!--end::Item-->
                    @endforeach
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Tasks-->
        </div>
        <!--end::Col-->
    </div>
@endsection

@section("scripts")
    <script type="text/javascript" src="/js/project/show.js"></script>
@endsection
