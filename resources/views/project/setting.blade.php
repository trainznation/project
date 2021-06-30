@extends("layouts.app")

@section("styles")

@endsection

@section("bread")
    {{ Breadcrumbs::render('project_show_setting', $project) }}
@endsection

@section("content")
    <div class="card mb-6 mb-xl-9" id="project" data-project-id="{{ $project->id }}">
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
                            <a href="#" class="btn btn-sm btn-primary me-3" data-bs-toggle="modal" data-bs-target="#add_task_modal">Ajouter une tache</a>
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
                        <a class="nav-link text-active-primary me-6" href="{{ route('project.show', $project->id) }}">Générale</a>
                    </li>
                    <!--end::Nav item-->
                    <!--begin::Nav item-->
                    <li class="nav-item">
                        <a class="nav-link text-active-primary me-6" href="{{ route('project.tasks', $project->id) }}">Tâches</a>
                    </li>
                    <!--end::Nav item-->
                    <!--begin::Nav item-->
                    <li class="nav-item">
                        <a class="nav-link text-active-primary me-6" href="{{ route('project.files', $project->id) }}">Fichiers</a>
                    </li>
                    <!--end::Nav item-->
                    <!--begin::Nav item-->
                    <li class="nav-item">
                        <a class="nav-link text-active-primary me-6" href="{{ route('project.activity', $project->id) }}">Activités</a>
                    </li>
                    <!--end::Nav item-->
                    <!--begin::Nav item-->
                    <li class="nav-item">
                        <a class="nav-link text-active-primary me-6" href="{{ route('project.conversations', $project->id) }}">Conversations</a>
                    </li>
                    <!--end::Nav item-->
                    <!--begin::Nav item-->
                    <li class="nav-item">
                        <a class="nav-link text-active-primary me-6 active" href="{{ route('project.setting', $project->id) }}">Configurations</a>
                    </li>
                    <!--end::Nav item-->
                </ul>
                <!--end::Nav links-->
            </div>
            <!--end::Nav wrapper-->
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header">
            <h3 class="card-title">Configuration du projet</h3>
        </div>
        <form action="{{ route('project.update', $project->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method("PUT")
            <div class="card-body">
                <div class="mb-10">
                    <label for="form-label" class="form-label">Titre du projet</label>
                    <input type="text" name="title" class="form-control" value="{{ $project->title }}" />
                </div>
                <div class="mb-10">
                    <label for="form-label" class="form-label">Courte description</label>
                    <textarea class="form-control" name="short_description" rows="3">{{ $project->short_description }}</textarea>
                </div>
                <div class="mb-10">
                    <label for="form-label" class="form-label">Description</label>
                    <textarea class="form-control editor" name="description">{{ $project->description }}</textarea>
                </div>
                <div class="mb-10">
                    <label for="form-label" class="form-label">Date du début du projet</label>
                    <input class="form-control form-control-solid" name="time_start" placeholder="Pick a date" id="time_start" value="{{ $project->time_start->format('m-D-Y') }}"/>
                </div>
                <div class="row mb-10">
                    <!--begin::Col-->
                    <div class="col-xl-3">
                        <div class="fs-6 fw-bold mt-2 mb-3">Publier</div>
                    </div>
                    <!--end::Col-->
                    <!--begin::Col-->
                    <div class="col-xl-9">
                        <div class="form-check form-check-custom form-check-solid mb-5">
                            <input class="form-check-input" type="radio" value="0" id="flexCheckboxSm" name="published" @if($project->published == 0) checked @endif/>
                            <label class="form-check-label" for="flexCheckboxSm">
                                Brouillon
                            </label>
                        </div>
                        <div class="form-check form-check-custom form-check-solid mb-5">
                            <input class="form-check-input" type="radio" value="1" id="flexCheckboxSm" name="published" @if($project->published == 1) checked @endif/>
                            <label class="form-check-label" for="flexCheckboxSm">
                                Privé
                            </label>
                        </div>
                        <div class="form-check form-check-custom form-check-solid">
                            <input class="form-check-input" type="radio" value="2" id="flexCheckboxSm" name="published" @if($project->published == 2) checked @endif/>
                            <label class="form-check-label" for="flexCheckboxSm">
                                Public
                            </label>
                        </div>
                    </div>
                    <!--end::Col-->
                </div>
                <hr class="divider" />
                <div class="row mb-10">
                    <!--begin::Col-->
                    <div class="col-xl-3">
                        <div class="fs-6 fw-bold mt-2 mb-3">Etat</div>
                    </div>
                    <!--end::Col-->
                    <!--begin::Col-->
                    <div class="col-xl-9">
                        <div class="form-check form-check-custom form-check-solid mb-5">
                            <input class="form-check-input" type="radio" value="0" id="flexCheckboxSm" name="state" @if($project->state == 0) checked @endif/>
                            <label class="form-check-label" for="flexCheckboxSm">
                                En cours
                            </label>
                        </div>
                        <div class="form-check form-check-custom form-check-solid mb-5">
                            <input class="form-check-input" type="radio" value="1" id="flexCheckboxSm" name="state" @if($project->state == 1) checked @endif/>
                            <label class="form-check-label" for="flexCheckboxSm">
                                Terminer
                            </label>
                        </div>
                        <div class="form-check form-check-custom form-check-solid mb-5">
                            <input class="form-check-input" type="radio" value="2" id="flexCheckboxSm" name="state" @if($project->state == 2) checked @endif/>
                            <label class="form-check-label" for="flexCheckboxSm">
                                Annuler
                            </label>
                        </div>
                        <div class="form-check form-check-custom form-check-solid">
                            <input class="form-check-input" type="radio" value="3" id="flexCheckboxSm" name="state" @if($project->state == 3) checked @endif/>
                            <label class="form-check-label" for="flexCheckboxSm">
                                En attente
                            </label>
                        </div>
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Row-->
            </div>
            <div class="card-footer d-flex justify-content-end py-6 px-9">
                <button class="btn btn-primary me-2" type="submit">Valider</button>
            </div>
        </form>
    </div>

    <div class="modal fade" id="kt_modal_users_search" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-650px">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header pb-0 border-0 justify-content-end">
                    <!--begin::Close-->
                    <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                        <!--begin::Svg Icon | path: icons/duotone/Navigation/Close.svg-->
                        <span class="svg-icon svg-icon-1">
							<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
								<g transform="translate(12.000000, 12.000000) rotate(-45.000000) translate(-12.000000, -12.000000) translate(4.000000, 4.000000)" fill="#000000">
									<rect fill="#000000" x="0" y="7" width="16" height="2" rx="1" />
									<rect fill="#000000" opacity="0.5" transform="translate(8.000000, 8.000000) rotate(-270.000000) translate(-8.000000, -8.000000)" x="0" y="7" width="16" height="2" rx="1" />
								</g>
							</svg>
						</span>
                        <!--end::Svg Icon-->
                    </div>
                    <!--end::Close-->
                </div>
                <!--begin::Modal header-->
                <!--begin::Modal body-->
                <div class="modal-body scroll-y mx-5 mx-xl-18 pt-0 pb-15">
                    <!--begin::Content-->
                    <div class="text-center mb-13">
                        <h1 class="mb-3">Recherche d'utilisateurs</h1>
                        <div class="text-gray-400 fw-bold fs-5">Inviter des utilisateurs à votre projet</div>
                    </div>
                    <!--end::Content-->
                    <!--begin::Search-->
                    <div id="kt_modal_users_search_handler" data-kt-search-keypress="true" data-kt-search-min-length="2" data-kt-search-enter="enter" data-kt-search-layout="inline">
                        <!--begin::Form-->
                        <form data-kt-search-element="form" class="w-100 position-relative mb-5" autocomplete="off">
                            <!--begin::Hidden input(Added to disable form autocomplete)-->
                            <input type="hidden" />
                            <!--end::Hidden input-->
                            <!--begin::Icon-->
                            <!--begin::Svg Icon | path: icons/duotone/General/Search.svg-->
                            <span class="svg-icon svg-icon-2 svg-icon-lg-1 svg-icon-gray-500 position-absolute top-50 ms-5 translate-middle-y">
								<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
									<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
										<rect x="0" y="0" width="24" height="24" />
										<path d="M14.2928932,16.7071068 C13.9023689,16.3165825 13.9023689,15.6834175 14.2928932,15.2928932 C14.6834175,14.9023689 15.3165825,14.9023689 15.7071068,15.2928932 L19.7071068,19.2928932 C20.0976311,19.6834175 20.0976311,20.3165825 19.7071068,20.7071068 C19.3165825,21.0976311 18.6834175,21.0976311 18.2928932,20.7071068 L14.2928932,16.7071068 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" />
										<path d="M11,16 C13.7614237,16 16,13.7614237 16,11 C16,8.23857625 13.7614237,6 11,6 C8.23857625,6 6,8.23857625 6,11 C6,13.7614237 8.23857625,16 11,16 Z M11,18 C7.13400675,18 4,14.8659932 4,11 C4,7.13400675 7.13400675,4 11,4 C14.8659932,4 18,7.13400675 18,11 C18,14.8659932 14.8659932,18 11,18 Z" fill="#000000" fill-rule="nonzero" />
									</g>
								</svg>
							</span>
                            <!--end::Svg Icon-->
                            <!--end::Icon-->
                            <!--begin::Input-->
                            <input type="text" class="form-control form-control-lg form-control-solid px-15" name="search" value="" placeholder="Recherche par nom, email, etc..." data-kt-search-element="input" />
                            <!--end::Input-->
                            <!--begin::Spinner-->
                            <span class="position-absolute top-50 end-0 translate-middle-y lh-0 d-none me-5" data-kt-search-element="spinner">
								<span class="spinner-border h-15px w-15px align-middle text-gray-400"></span>
							</span>
                            <!--end::Spinner-->
                            <!--begin::Reset-->
                            <span class="btn btn-flush btn-active-color-primary position-absolute top-50 end-0 translate-middle-y lh-0 me-5 d-none" data-kt-search-element="clear">
								<!--begin::Svg Icon | path: icons/duotone/Navigation/Close.svg-->
								<span class="svg-icon svg-icon-2 svg-icon-lg-1 me-0">
									<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
										<g transform="translate(12.000000, 12.000000) rotate(-45.000000) translate(-12.000000, -12.000000) translate(4.000000, 4.000000)" fill="#000000">
											<rect fill="#000000" x="0" y="7" width="16" height="2" rx="1" />
											<rect fill="#000000" opacity="0.5" transform="translate(8.000000, 8.000000) rotate(-270.000000) translate(-8.000000, -8.000000)" x="0" y="7" width="16" height="2" rx="1" />
										</g>
									</svg>
								</span>
							</span>
                            <!--end::Reset-->
                        </form>
                        <!--end::Form-->
                        <!--begin::Wrapper-->
                        <div class="py-5">
                            <!--begin::Suggestions-->
                            <div data-kt-search-element="suggestions">
                                <!--begin::Heading-->
                                <h3 class="fw-bold mb-5">Recherche récentes:</h3>
                                <!--end::Heading-->
                                <!--begin::Users-->
                                <div class="mh-375px scroll-y me-n7 pe-7">
                                    @foreach(\App\Models\User::limit(5)->get() as $user)
                                        <a href="#" class="d-flex align-items-center p-3 rounded bg-state-light bg-state-opacity-50 mb-1">
                                            <!--begin::Avatar-->
                                            <div class="symbol symbol-35px symbol-circle me-5">
                                                <div class="symbol-label fs-2 fw-bold text-success">{{ \Illuminate\Support\Str::limit($user->name, 2, '') }}</div>
                                            </div>
                                            <!--end::Avatar-->
                                            <!--begin::Info-->
                                            <div class="fw-bold">
                                                <span class="fs-6 text-gray-800 me-2">{{ $user->name }}</span>
                                                <span class="badge badge-light">{{ $user->email }}</span>
                                            </div>
                                            <!--end::Info-->
                                        </a>
                                    @endforeach
                                </div>
                                <!--end::Users-->
                            </div>
                            <!--end::Suggestions-->
                            <!--begin::Results(add d-none to below element to hide the users list by default)-->
                            <div data-kt-search-element="results" class="d-none">
                                <!--begin::Users-->
                                <div class="mh-375px scroll-y me-n7 pe-7">
                                    @foreach(\App\Models\User::all() as $user)
                                    <!--begin::User-->
                                    <div class="rounded d-flex flex-stack bg-active-lighten p-4" data-user-id="{{ $user->id }}">
                                        <!--begin::Details-->
                                        <div class="d-flex align-items-center">
                                            <!--begin::Checkbox-->
                                            <label class="form-check form-check-custom form-check-solid me-5">
                                                <input class="form-check-input" type="checkbox" name="users" data-kt-check="true" data-kt-check-target="[data-user-id='{{ $user->id }}']" value="{{ $user->id }}" />
                                            </label>
                                            <!--end::Checkbox-->
                                            <!--begin::Avatar-->
                                            <div class="symbol symbol-35px symbol-circle">
                                                <div class="symbol-label fs-2 fw-bold text-success">{{ \Illuminate\Support\Str::limit($user->name, 2, '') }}</div>
                                            </div>
                                            <!--end::Avatar-->
                                            <!--begin::Details-->
                                            <div class="ms-5">
                                                <a href="#" class="fs-5 fw-bolder text-gray-900 text-hover-primary mb-2">{{ $user->name }}</a>
                                                <div class="fw-bold text-gray-400">{{ $user->email }}</div>
                                            </div>
                                            <!--end::Details-->
                                        </div>
                                        <!--end::Details-->
                                    </div>
                                    <!--end::User-->
                                    <!--begin::Separator-->
                                    <div class="border-bottom border-gray-300 border-bottom-dashed"></div>
                                    <!--end::Separator-->
                                    @endforeach
                                </div>
                                <!--end::Users-->
                                <!--begin::Actions-->
                                <div class="d-flex flex-center mt-15">
                                    <button type="reset" id="kt_modal_users_search_reset" data-bs-dismiss="modal" class="btn btn-active-light me-3">Annuler</button>
                                    <button type="submit" id="kt_modal_users_search_submit" class="btn btn-primary">Ajouter les utilisateurs selectionner</button>
                                </div>
                                <!--end::Actions-->
                            </div>
                            <!--end::Results-->
                            <!--begin::Empty-->
                            <div data-kt-search-element="empty" class="text-center d-none">
                                <!--begin::Message-->
                                <div class="fw-bold py-10">
                                    <div class="text-gray-600 fs-3 mb-2">Aucun utilisateur trouver</div>
                                    <div class="text-gray-400 fs-6">Essayer avec le nom ou l'adresse mail</div>
                                </div>
                                <!--end::Message-->
                                <!--begin::Illustration-->
                                <div class="text-center px-5">
                                    <img src="media/illustrations/alert.png" alt="" class="mw-100 mh-200px" />
                                </div>
                                <!--end::Illustration-->
                            </div>
                            <!--end::Empty-->
                        </div>
                        <!--end::Wrapper-->
                    </div>
                    <!--end::Search-->
                </div>
                <!--end::Modal body-->
            </div>
            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
    </div>
    <div class="modal fade" tabindex="-1" id="add_task_modal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Nouvelle Tâche</h5>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <span class="svg-icon svg-icon-2x">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                <g transform="translate(12.000000, 12.000000) rotate(-45.000000) translate(-12.000000, -12.000000) translate(4.000000, 4.000000)" fill="#000000">
                                    <rect fill="#000000" x="0" y="7" width="16" height="2" rx="1"/>
                                    <rect fill="#000000" opacity="0.5" transform="translate(8.000000, 8.000000) rotate(-270.000000) translate(-8.000000, -8.000000) " x="0" y="7" width="16" height="2" rx="1"/>
                                </g>
                            </svg>
                        </span>
                    </div>
                    <!--end::Close-->
                </div>

                <form action="{{ route('project.addTask', $project->id) }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-10">
                            <label for="exampleFormControlInput1" class="required form-label">Titre</label>
                            <input type="text" class="form-control form-control-solid" placeholder="Titre de la tâche" name="title"/>
                        </div>
                        <div class="mb-10">
                            <label for="exampleFormControlInput1" class="required form-label">Description</label>
                            <textarea class="form-control form-control-solid editor" name="description"></textarea>
                        </div>

                        <div class="mb-10">
                            <label for="exampleFormControlInput1" class="required form-label">Priorité</label>
                            <select class="form-select" data-controls="select2" data-placeholder="Selectionner une priorité">
                                <option value=""></option>
                                <option value="0">Basse</option>
                                <option value="1">Moyenne</option>
                                <option value="2">Haute</option>
                            </select>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <label for="exampleFormControlInput1" class="required form-label">Etat actuelle</label>
                                <div class="form-check form-check-custom form-check-solid me-10">
                                    <input class="form-check-input h-30px w-30px" type="radio" value="0" id="flexRadio30" name="status"/>
                                    <label class="form-check-label" for="flexRadio30">
                                        Ouvert
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check form-check-custom form-check-solid me-10">
                                    <input class="form-check-input h-30px w-30px" type="radio" value="1" id="flexRadio30" name="status"/>
                                    <label class="form-check-label" for="flexRadio30">
                                        Fermer
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary">Sauvegarder</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section("scripts")
    <script type="text/javascript" src="/plugins/custom/ckeditor/ckeditor-classic.bundle.js"></script>
    <script type="text/javascript" src="/js/project/show_setting.js"></script>
@endsection
