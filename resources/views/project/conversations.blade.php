@extends("layouts.app")

@section("styles")

@endsection

@section("bread")
    {{ Breadcrumbs::render('project_show_conversation', $project) }}
@endsection

@section("content")
    <div class="card mb-6 mb-xl-9" id="project" data-project-id="{{ $project->id }}" data-user-id="{{ auth()->user()->id }}">
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
                        <a class="nav-link text-active-primary me-6 active" href="{{ route('project.conversations', $project->id) }}">Conversations</a>
                    </li>
                    <!--end::Nav item-->
                    <!--begin::Nav item-->
                    <li class="nav-item">
                        <a class="nav-link text-active-primary me-6" href="{{ route('project.setting', $project->id) }}">Configurations</a>
                    </li>
                    <!--end::Nav item-->
                </ul>
                <!--end::Nav links-->
            </div>
            <!--end::Nav wrapper-->
        </div>
    </div>

    <div class="post d-flex flex-column-fluid" id="kt_post">
        <!--begin::Container-->
        <div id="kt_content_container" class="container">
            <!--begin::Layout-->
            <div class="d-flex flex-column flex-lg-row">
                <!--begin::Sidebar-->
                <div class="flex-column flex-lg-row-auto w-100 w-lg-300px w-xl-400px mb-10 mb-lg-0">
                    <!--begin::Contacts-->
                    <div class="card card-flush">
                        <!--begin::Card header-->
                        <div class="card-header pt-7" id="kt_chat_contacts_header">
                            <!--begin::Form-->
                            <h3>Liste des Utilisateurs</h3>
                            <!--end::Form-->
                        </div>
                        <!--end::Card header-->
                        <!--begin::Card body-->
                        <div class="card-body pt-5" id="kt_chat_contacts_body">
                            <!--begin::List-->
                            <div class="scroll-y me-n5 pe-5 h-200px h-lg-auto" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_header, #kt_toolbar, #kt_footer, #kt_chat_contacts_header" data-kt-scroll-wrappers="#kt_content, #kt_chat_contacts_body" data-kt-scroll-offset="0px">
                                <!--begin::User-->
                                @foreach($project->users()->where('user_id', '!=', auth()->user()->id)->get() as $user)
                                <div class="d-flex flex-stack py-4">
                                    <!--begin::Details-->
                                    <div class="d-flex align-items-center">
                                        <!--begin::Avatar-->
                                        <div class="symbol symbol-45px symbol-circle">
                                            <span class="symbol-label bg-light-danger text-danger fs-6 fw-bolder">{{ \Illuminate\Support\Str::limit($user->name, 1, '') }}</span>
                                            @if(Cache::has('user-is-online-'.$user->id))
                                                <span class="symbol-badge badge badge-circle bg-success top-100 start-100">&nbsp;</span>
                                            @else
                                                <span class="symbol-badge badge badge-circle bg-danger top-100 start-100">&nbsp;</span>
                                            @endif
                                        </div>
                                        <!--end::Avatar-->
                                        <!--begin::Details-->
                                        <div class="ms-5">
                                            <a href="#" class="fs-5 fw-bolder text-gray-900 text-hover-primary mb-2">{{ $user->name }}</a>
                                        </div>
                                        <!--end::Details-->
                                    </div>
                                    <!--end::Details-->
                                    <!--begin::Lat seen-->
                                    <div class="d-flex flex-column align-items-end ms-2">
                                        @if($user->last_seen != null)
                                            <span class="text-muted fs-7 mb-1">{{ $user->last_seen->longAbsoluteDiffForHumans() }}</span>
                                        @endif
                                    </div>
                                    <!--end::Lat seen-->
                                </div>
                                <div class="separator separator-dashed d-none"></div>
                                @endforeach
                                <!--end::User-->
                            </div>
                            <!--end::List-->
                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--end::Contacts-->
                </div>
                <!--end::Sidebar-->
                <!--begin::Content-->
                <div class="flex-lg-row-fluid ms-lg-7 ms-xl-10">
                    <!--begin::Messenger-->
                    <div class="card" id="kt_drawer_chat_messenger">
                        <!--begin::Card header-->
                        <div class="card-header" id="kt_chat_messenger_header">
                            <!--begin::Title-->
                            <div class="card-title">
                                <!--begin::Users-->
                                <div class="symbol-group symbol-hover">
                                    @foreach($project->users()->where('user_id', '!=', auth()->user()->id)->get() as $user)
                                        <!--begin::Avatar-->
                                            <div class="symbol symbol-35px symbol-circle">
                                                <span class="symbol-label bg-light-{{ \Illuminate\Support\Arr::random(["danger", "success", "primary", "info", "warning"]) }} text-{{ \Illuminate\Support\Arr::random(["danger", "success", "primary", "info", "warning"]) }} 40px" data-bs-toggle="tooltip" title="{{ $user->name }}">{{ \Illuminate\Support\Str::limit($user->name, 1, '') }}</span>
                                            </div>
                                            <!--end::Avatar-->
                                    @endforeach
                                </div>
                                <!--end::Users-->
                            </div>
                            <!--end::Title-->
                        </div>
                        <!--end::Card header-->
                        <!--begin::Card body-->
                        <div class="card-body" id="kt_chat_messenger_body">
                            <!--begin::Messages-->
                            <div class="scroll-y me-n5 pe-5 h-300px h-lg-auto" data-kt-element="messages" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_header, #kt_toolbar, #kt_footer, #kt_chat_messenger_header, #kt_chat_messenger_footer" data-kt-scroll-wrappers="#kt_content, #kt_chat_messenger_body" data-kt-scroll-offset="-2px">
                                <!--begin::Message(in)-->
                                <div class="d-flex justify-content-start mb-10">
                                    <!--begin::Wrapper-->
                                    <div class="d-flex flex-column align-items-start">
                                        <!--begin::User-->
                                        <div class="d-flex align-items-center mb-2">
                                            <!--begin::Avatar-->
                                            <div class="symbol symbol-35px symbol-circle">
                                                <img alt="Pic" src="assets/media/avatars/150-15.jpg" />
                                            </div>
                                            <!--end::Avatar-->
                                            <!--begin::Details-->
                                            <div class="ms-3">
                                                <a href="#" class="fs-5 fw-bolder text-gray-900 text-hover-primary me-1">Brian Cox</a>
                                                <span class="text-muted fs-7 mb-1">2 mins</span>
                                            </div>
                                            <!--end::Details-->
                                        </div>
                                        <!--end::User-->
                                        <!--begin::Text-->
                                        <div class="p-5 rounded bg-light-info text-dark fw-bold mw-lg-400px text-start" data-kt-element="message-text">How likely are you to recommend our company to your friends and family ?</div>
                                        <!--end::Text-->
                                    </div>
                                    <!--end::Wrapper-->
                                </div>
                                <!--end::Message(in)-->
                                <!--begin::Message(out)-->
                                <div class="d-flex justify-content-end mb-10">
                                    <!--begin::Wrapper-->
                                    <div class="d-flex flex-column align-items-end">
                                        <!--begin::User-->
                                        <div class="d-flex align-items-center mb-2">
                                            <!--begin::Details-->
                                            <div class="me-3">
                                                <span class="text-muted fs-7 mb-1">5 mins</span>
                                                <a href="#" class="fs-5 fw-bolder text-gray-900 text-hover-primary ms-1">You</a>
                                            </div>
                                            <!--end::Details-->
                                            <!--begin::Avatar-->
                                            <div class="symbol symbol-35px symbol-circle">
                                                <img alt="Pic" src="assets/media/avatars/150-2.jpg" />
                                            </div>
                                            <!--end::Avatar-->
                                        </div>
                                        <!--end::User-->
                                        <!--begin::Text-->
                                        <div class="p-5 rounded bg-light-primary text-dark fw-bold mw-lg-400px text-end" data-kt-element="message-text">Hey there, we’re just writing to let you know that you’ve been subscribed to a repository on GitHub.</div>
                                        <!--end::Text-->
                                    </div>
                                    <!--end::Wrapper-->
                                </div>
                                <!--end::Message(out)-->
                            </div>
                            <!--end::Messages-->
                        </div>
                        <!--end::Card body-->
                        <!--begin::Card footer-->
                        <div class="card-footer pt-4" id="kt_chat_messenger_footer">
                            <!--begin::Input-->
                            <textarea class="form-control form-control-flush mb-3" rows="1" data-kt-element="input" placeholder="Type a message"></textarea>
                            <!--end::Input-->
                            <!--begin:Toolbar-->
                            <div class="d-flex flex-stack">
                                <!--begin::Actions-->
                                <div class="d-flex align-items-center me-2">
                                    <button class="btn btn-sm btn-icon btn-active-light-primary me-1" type="button" data-bs-toggle="tooltip" title="Coming soon">
                                        <i class="bi bi-paperclip fs-3"></i>
                                    </button>
                                    <button class="btn btn-sm btn-icon btn-active-light-primary me-1" type="button" data-bs-toggle="tooltip" title="Coming soon">
                                        <i class="bi bi-upload fs-3"></i>
                                    </button>
                                </div>
                                <!--end::Actions-->
                                <!--begin::Send-->
                                <button class="btn btn-primary" type="button" data-kt-element="send">Send</button>
                                <!--end::Send-->
                            </div>
                            <!--end::Toolbar-->
                        </div>
                        <!--end::Card footer-->
                    </div>
                    <!--end::Messenger-->
                </div>
                <!--end::Content-->
            </div>
            <!--end::Layout-->
            <!--begin::Modals-->
            <!--begin::Modal - View Users-->
            <div class="modal fade" id="kt_modal_view_users" tabindex="-1" aria-hidden="true">
                <!--begin::Modal dialog-->
                <div class="modal-dialog mw-650px">
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
                            <!--begin::Heading-->
                            <div class="text-center mb-13">
                                <!--begin::Title-->
                                <h1 class="mb-3">Browse Users</h1>
                                <!--end::Title-->
                                <!--begin::Description-->
                                <div class="text-gray-400 fw-bold fs-5">If you need more info, please check out our
                                    <a href="#" class="link-primary fw-bolder">Users Directory</a>.</div>
                                <!--end::Description-->
                            </div>
                            <!--end::Heading-->
                            <!--begin::Users-->
                            <div class="mb-15">
                                <!--begin::List-->
                                <div class="mh-375px scroll-y me-n7 pe-7">
                                    <!--begin::User-->
                                    <div class="d-flex flex-stack py-5 border-bottom border-gray-300 border-bottom-dashed">
                                        <!--begin::Details-->
                                        <div class="d-flex align-items-center">
                                            <!--begin::Avatar-->
                                            <div class="symbol symbol-35px symbol-circle">
                                                <img alt="Pic" src="assets/media/avatars/150-1.jpg" />
                                            </div>
                                            <!--end::Avatar-->
                                            <!--begin::Details-->
                                            <div class="ms-6">
                                                <!--begin::Name-->
                                                <a href="#" class="d-flex align-items-center fs-5 fw-bolder text-dark text-hover-primary">Emma Smith
                                                    <span class="badge badge-light fs-8 fw-bold ms-2">Art Director</span></a>
                                                <!--end::Name-->
                                                <!--begin::Email-->
                                                <div class="fw-bold text-gray-400">e.smith@kpmg.com.au</div>
                                                <!--end::Email-->
                                            </div>
                                            <!--end::Details-->
                                        </div>
                                        <!--end::Details-->
                                        <!--begin::Stats-->
                                        <div class="d-flex">
                                            <!--begin::Sales-->
                                            <div class="text-end">
                                                <div class="fs-5 fw-bolder text-dark">$23,000</div>
                                                <div class="fs-7 text-muted">Sales</div>
                                            </div>
                                            <!--end::Sales-->
                                        </div>
                                        <!--end::Stats-->
                                    </div>
                                    <!--end::User-->
                                    <!--begin::User-->
                                    <div class="d-flex flex-stack py-5 border-bottom border-gray-300 border-bottom-dashed">
                                        <!--begin::Details-->
                                        <div class="d-flex align-items-center">
                                            <!--begin::Avatar-->
                                            <div class="symbol symbol-35px symbol-circle">
                                                <span class="symbol-label bg-light-danger text-danger fw-bold">M</span>
                                            </div>
                                            <!--end::Avatar-->
                                            <!--begin::Details-->
                                            <div class="ms-6">
                                                <!--begin::Name-->
                                                <a href="#" class="d-flex align-items-center fs-5 fw-bolder text-dark text-hover-primary">Melody Macy
                                                    <span class="badge badge-light fs-8 fw-bold ms-2">Marketing Analytic</span></a>
                                                <!--end::Name-->
                                                <!--begin::Email-->
                                                <div class="fw-bold text-gray-400">melody@altbox.com</div>
                                                <!--end::Email-->
                                            </div>
                                            <!--end::Details-->
                                        </div>
                                        <!--end::Details-->
                                        <!--begin::Stats-->
                                        <div class="d-flex">
                                            <!--begin::Sales-->
                                            <div class="text-end">
                                                <div class="fs-5 fw-bolder text-dark">$50,500</div>
                                                <div class="fs-7 text-muted">Sales</div>
                                            </div>
                                            <!--end::Sales-->
                                        </div>
                                        <!--end::Stats-->
                                    </div>
                                    <!--end::User-->
                                    <!--begin::User-->
                                    <div class="d-flex flex-stack py-5 border-bottom border-gray-300 border-bottom-dashed">
                                        <!--begin::Details-->
                                        <div class="d-flex align-items-center">
                                            <!--begin::Avatar-->
                                            <div class="symbol symbol-35px symbol-circle">
                                                <img alt="Pic" src="assets/media/avatars/150-2.jpg" />
                                            </div>
                                            <!--end::Avatar-->
                                            <!--begin::Details-->
                                            <div class="ms-6">
                                                <!--begin::Name-->
                                                <a href="#" class="d-flex align-items-center fs-5 fw-bolder text-dark text-hover-primary">Max Smith
                                                    <span class="badge badge-light fs-8 fw-bold ms-2">Software Enginer</span></a>
                                                <!--end::Name-->
                                                <!--begin::Email-->
                                                <div class="fw-bold text-gray-400">max@kt.com</div>
                                                <!--end::Email-->
                                            </div>
                                            <!--end::Details-->
                                        </div>
                                        <!--end::Details-->
                                        <!--begin::Stats-->
                                        <div class="d-flex">
                                            <!--begin::Sales-->
                                            <div class="text-end">
                                                <div class="fs-5 fw-bolder text-dark">$75,900</div>
                                                <div class="fs-7 text-muted">Sales</div>
                                            </div>
                                            <!--end::Sales-->
                                        </div>
                                        <!--end::Stats-->
                                    </div>
                                    <!--end::User-->
                                    <!--begin::User-->
                                    <div class="d-flex flex-stack py-5 border-bottom border-gray-300 border-bottom-dashed">
                                        <!--begin::Details-->
                                        <div class="d-flex align-items-center">
                                            <!--begin::Avatar-->
                                            <div class="symbol symbol-35px symbol-circle">
                                                <img alt="Pic" src="assets/media/avatars/150-4.jpg" />
                                            </div>
                                            <!--end::Avatar-->
                                            <!--begin::Details-->
                                            <div class="ms-6">
                                                <!--begin::Name-->
                                                <a href="#" class="d-flex align-items-center fs-5 fw-bolder text-dark text-hover-primary">Sean Bean
                                                    <span class="badge badge-light fs-8 fw-bold ms-2">Web Developer</span></a>
                                                <!--end::Name-->
                                                <!--begin::Email-->
                                                <div class="fw-bold text-gray-400">sean@dellito.com</div>
                                                <!--end::Email-->
                                            </div>
                                            <!--end::Details-->
                                        </div>
                                        <!--end::Details-->
                                        <!--begin::Stats-->
                                        <div class="d-flex">
                                            <!--begin::Sales-->
                                            <div class="text-end">
                                                <div class="fs-5 fw-bolder text-dark">$10,500</div>
                                                <div class="fs-7 text-muted">Sales</div>
                                            </div>
                                            <!--end::Sales-->
                                        </div>
                                        <!--end::Stats-->
                                    </div>
                                    <!--end::User-->
                                    <!--begin::User-->
                                    <div class="d-flex flex-stack py-5 border-bottom border-gray-300 border-bottom-dashed">
                                        <!--begin::Details-->
                                        <div class="d-flex align-items-center">
                                            <!--begin::Avatar-->
                                            <div class="symbol symbol-35px symbol-circle">
                                                <img alt="Pic" src="assets/media/avatars/150-15.jpg" />
                                            </div>
                                            <!--end::Avatar-->
                                            <!--begin::Details-->
                                            <div class="ms-6">
                                                <!--begin::Name-->
                                                <a href="#" class="d-flex align-items-center fs-5 fw-bolder text-dark text-hover-primary">Brian Cox
                                                    <span class="badge badge-light fs-8 fw-bold ms-2">UI/UX Designer</span></a>
                                                <!--end::Name-->
                                                <!--begin::Email-->
                                                <div class="fw-bold text-gray-400">brian@exchange.com</div>
                                                <!--end::Email-->
                                            </div>
                                            <!--end::Details-->
                                        </div>
                                        <!--end::Details-->
                                        <!--begin::Stats-->
                                        <div class="d-flex">
                                            <!--begin::Sales-->
                                            <div class="text-end">
                                                <div class="fs-5 fw-bolder text-dark">$20,000</div>
                                                <div class="fs-7 text-muted">Sales</div>
                                            </div>
                                            <!--end::Sales-->
                                        </div>
                                        <!--end::Stats-->
                                    </div>
                                    <!--end::User-->
                                    <!--begin::User-->
                                    <div class="d-flex flex-stack py-5 border-bottom border-gray-300 border-bottom-dashed">
                                        <!--begin::Details-->
                                        <div class="d-flex align-items-center">
                                            <!--begin::Avatar-->
                                            <div class="symbol symbol-35px symbol-circle">
                                                <span class="symbol-label bg-light-warning text-warning fw-bold">M</span>
                                            </div>
                                            <!--end::Avatar-->
                                            <!--begin::Details-->
                                            <div class="ms-6">
                                                <!--begin::Name-->
                                                <a href="#" class="d-flex align-items-center fs-5 fw-bolder text-dark text-hover-primary">Mikaela Collins
                                                    <span class="badge badge-light fs-8 fw-bold ms-2">Head Of Marketing</span></a>
                                                <!--end::Name-->
                                                <!--begin::Email-->
                                                <div class="fw-bold text-gray-400">mikaela@pexcom.com</div>
                                                <!--end::Email-->
                                            </div>
                                            <!--end::Details-->
                                        </div>
                                        <!--end::Details-->
                                        <!--begin::Stats-->
                                        <div class="d-flex">
                                            <!--begin::Sales-->
                                            <div class="text-end">
                                                <div class="fs-5 fw-bolder text-dark">$9,300</div>
                                                <div class="fs-7 text-muted">Sales</div>
                                            </div>
                                            <!--end::Sales-->
                                        </div>
                                        <!--end::Stats-->
                                    </div>
                                    <!--end::User-->
                                    <!--begin::User-->
                                    <div class="d-flex flex-stack py-5 border-bottom border-gray-300 border-bottom-dashed">
                                        <!--begin::Details-->
                                        <div class="d-flex align-items-center">
                                            <!--begin::Avatar-->
                                            <div class="symbol symbol-35px symbol-circle">
                                                <img alt="Pic" src="assets/media/avatars/150-8.jpg" />
                                            </div>
                                            <!--end::Avatar-->
                                            <!--begin::Details-->
                                            <div class="ms-6">
                                                <!--begin::Name-->
                                                <a href="#" class="d-flex align-items-center fs-5 fw-bolder text-dark text-hover-primary">Francis Mitcham
                                                    <span class="badge badge-light fs-8 fw-bold ms-2">Software Arcitect</span></a>
                                                <!--end::Name-->
                                                <!--begin::Email-->
                                                <div class="fw-bold text-gray-400">f.mitcham@kpmg.com.au</div>
                                                <!--end::Email-->
                                            </div>
                                            <!--end::Details-->
                                        </div>
                                        <!--end::Details-->
                                        <!--begin::Stats-->
                                        <div class="d-flex">
                                            <!--begin::Sales-->
                                            <div class="text-end">
                                                <div class="fs-5 fw-bolder text-dark">$15,000</div>
                                                <div class="fs-7 text-muted">Sales</div>
                                            </div>
                                            <!--end::Sales-->
                                        </div>
                                        <!--end::Stats-->
                                    </div>
                                    <!--end::User-->
                                    <!--begin::User-->
                                    <div class="d-flex flex-stack py-5 border-bottom border-gray-300 border-bottom-dashed">
                                        <!--begin::Details-->
                                        <div class="d-flex align-items-center">
                                            <!--begin::Avatar-->
                                            <div class="symbol symbol-35px symbol-circle">
                                                <span class="symbol-label bg-light-danger text-danger fw-bold">O</span>
                                            </div>
                                            <!--end::Avatar-->
                                            <!--begin::Details-->
                                            <div class="ms-6">
                                                <!--begin::Name-->
                                                <a href="#" class="d-flex align-items-center fs-5 fw-bolder text-dark text-hover-primary">Olivia Wild
                                                    <span class="badge badge-light fs-8 fw-bold ms-2">System Admin</span></a>
                                                <!--end::Name-->
                                                <!--begin::Email-->
                                                <div class="fw-bold text-gray-400">olivia@corpmail.com</div>
                                                <!--end::Email-->
                                            </div>
                                            <!--end::Details-->
                                        </div>
                                        <!--end::Details-->
                                        <!--begin::Stats-->
                                        <div class="d-flex">
                                            <!--begin::Sales-->
                                            <div class="text-end">
                                                <div class="fs-5 fw-bolder text-dark">$23,000</div>
                                                <div class="fs-7 text-muted">Sales</div>
                                            </div>
                                            <!--end::Sales-->
                                        </div>
                                        <!--end::Stats-->
                                    </div>
                                    <!--end::User-->
                                    <!--begin::User-->
                                    <div class="d-flex flex-stack py-5 border-bottom border-gray-300 border-bottom-dashed">
                                        <!--begin::Details-->
                                        <div class="d-flex align-items-center">
                                            <!--begin::Avatar-->
                                            <div class="symbol symbol-35px symbol-circle">
                                                <span class="symbol-label bg-light-primary text-primary fw-bold">N</span>
                                            </div>
                                            <!--end::Avatar-->
                                            <!--begin::Details-->
                                            <div class="ms-6">
                                                <!--begin::Name-->
                                                <a href="#" class="d-flex align-items-center fs-5 fw-bolder text-dark text-hover-primary">Neil Owen
                                                    <span class="badge badge-light fs-8 fw-bold ms-2">Account Manager</span></a>
                                                <!--end::Name-->
                                                <!--begin::Email-->
                                                <div class="fw-bold text-gray-400">owen.neil@gmail.com</div>
                                                <!--end::Email-->
                                            </div>
                                            <!--end::Details-->
                                        </div>
                                        <!--end::Details-->
                                        <!--begin::Stats-->
                                        <div class="d-flex">
                                            <!--begin::Sales-->
                                            <div class="text-end">
                                                <div class="fs-5 fw-bolder text-dark">$45,800</div>
                                                <div class="fs-7 text-muted">Sales</div>
                                            </div>
                                            <!--end::Sales-->
                                        </div>
                                        <!--end::Stats-->
                                    </div>
                                    <!--end::User-->
                                    <!--begin::User-->
                                    <div class="d-flex flex-stack py-5 border-bottom border-gray-300 border-bottom-dashed">
                                        <!--begin::Details-->
                                        <div class="d-flex align-items-center">
                                            <!--begin::Avatar-->
                                            <div class="symbol symbol-35px symbol-circle">
                                                <img alt="Pic" src="assets/media/avatars/150-6.jpg" />
                                            </div>
                                            <!--end::Avatar-->
                                            <!--begin::Details-->
                                            <div class="ms-6">
                                                <!--begin::Name-->
                                                <a href="#" class="d-flex align-items-center fs-5 fw-bolder text-dark text-hover-primary">Dan Wilson
                                                    <span class="badge badge-light fs-8 fw-bold ms-2">Web Desinger</span></a>
                                                <!--end::Name-->
                                                <!--begin::Email-->
                                                <div class="fw-bold text-gray-400">dam@consilting.com</div>
                                                <!--end::Email-->
                                            </div>
                                            <!--end::Details-->
                                        </div>
                                        <!--end::Details-->
                                        <!--begin::Stats-->
                                        <div class="d-flex">
                                            <!--begin::Sales-->
                                            <div class="text-end">
                                                <div class="fs-5 fw-bolder text-dark">$90,500</div>
                                                <div class="fs-7 text-muted">Sales</div>
                                            </div>
                                            <!--end::Sales-->
                                        </div>
                                        <!--end::Stats-->
                                    </div>
                                    <!--end::User-->
                                    <!--begin::User-->
                                    <div class="d-flex flex-stack py-5 border-bottom border-gray-300 border-bottom-dashed">
                                        <!--begin::Details-->
                                        <div class="d-flex align-items-center">
                                            <!--begin::Avatar-->
                                            <div class="symbol symbol-35px symbol-circle">
                                                <span class="symbol-label bg-light-danger text-danger fw-bold">E</span>
                                            </div>
                                            <!--end::Avatar-->
                                            <!--begin::Details-->
                                            <div class="ms-6">
                                                <!--begin::Name-->
                                                <a href="#" class="d-flex align-items-center fs-5 fw-bolder text-dark text-hover-primary">Emma Bold
                                                    <span class="badge badge-light fs-8 fw-bold ms-2">Corporate Finance</span></a>
                                                <!--end::Name-->
                                                <!--begin::Email-->
                                                <div class="fw-bold text-gray-400">emma@intenso.com</div>
                                                <!--end::Email-->
                                            </div>
                                            <!--end::Details-->
                                        </div>
                                        <!--end::Details-->
                                        <!--begin::Stats-->
                                        <div class="d-flex">
                                            <!--begin::Sales-->
                                            <div class="text-end">
                                                <div class="fs-5 fw-bolder text-dark">$5,000</div>
                                                <div class="fs-7 text-muted">Sales</div>
                                            </div>
                                            <!--end::Sales-->
                                        </div>
                                        <!--end::Stats-->
                                    </div>
                                    <!--end::User-->
                                    <!--begin::User-->
                                    <div class="d-flex flex-stack py-5 border-bottom border-gray-300 border-bottom-dashed">
                                        <!--begin::Details-->
                                        <div class="d-flex align-items-center">
                                            <!--begin::Avatar-->
                                            <div class="symbol symbol-35px symbol-circle">
                                                <img alt="Pic" src="assets/media/avatars/150-7.jpg" />
                                            </div>
                                            <!--end::Avatar-->
                                            <!--begin::Details-->
                                            <div class="ms-6">
                                                <!--begin::Name-->
                                                <a href="#" class="d-flex align-items-center fs-5 fw-bolder text-dark text-hover-primary">Ana Crown
                                                    <span class="badge badge-light fs-8 fw-bold ms-2">Customer Relationship</span></a>
                                                <!--end::Name-->
                                                <!--begin::Email-->
                                                <div class="fw-bold text-gray-400">ana.cf@limtel.com</div>
                                                <!--end::Email-->
                                            </div>
                                            <!--end::Details-->
                                        </div>
                                        <!--end::Details-->
                                        <!--begin::Stats-->
                                        <div class="d-flex">
                                            <!--begin::Sales-->
                                            <div class="text-end">
                                                <div class="fs-5 fw-bolder text-dark">$70,000</div>
                                                <div class="fs-7 text-muted">Sales</div>
                                            </div>
                                            <!--end::Sales-->
                                        </div>
                                        <!--end::Stats-->
                                    </div>
                                    <!--end::User-->
                                    <!--begin::User-->
                                    <div class="d-flex flex-stack py-5">
                                        <!--begin::Details-->
                                        <div class="d-flex align-items-center">
                                            <!--begin::Avatar-->
                                            <div class="symbol symbol-35px symbol-circle">
                                                <span class="symbol-label bg-light-info text-info fw-bold">A</span>
                                            </div>
                                            <!--end::Avatar-->
                                            <!--begin::Details-->
                                            <div class="ms-6">
                                                <!--begin::Name-->
                                                <a href="#" class="d-flex align-items-center fs-5 fw-bolder text-dark text-hover-primary">Robert Doe
                                                    <span class="badge badge-light fs-8 fw-bold ms-2">Marketing Executive</span></a>
                                                <!--end::Name-->
                                                <!--begin::Email-->
                                                <div class="fw-bold text-gray-400">robert@benko.com</div>
                                                <!--end::Email-->
                                            </div>
                                            <!--end::Details-->
                                        </div>
                                        <!--end::Details-->
                                        <!--begin::Stats-->
                                        <div class="d-flex">
                                            <!--begin::Sales-->
                                            <div class="text-end">
                                                <div class="fs-5 fw-bolder text-dark">$45,500</div>
                                                <div class="fs-7 text-muted">Sales</div>
                                            </div>
                                            <!--end::Sales-->
                                        </div>
                                        <!--end::Stats-->
                                    </div>
                                    <!--end::User-->
                                </div>
                                <!--end::List-->
                            </div>
                            <!--end::Users-->
                            <!--begin::Notice-->
                            <div class="d-flex justify-content-between">
                                <!--begin::Label-->
                                <div class="fw-bold">
                                    <label class="fs-6">Adding Users by Team Members</label>
                                    <div class="fs-7 text-gray-400">If you need more info, please check budget planning</div>
                                </div>
                                <!--end::Label-->
                                <!--begin::Switch-->
                                <label class="form-check form-switch form-check-custom form-check-solid">
                                    <input class="form-check-input" type="checkbox" value="" checked="checked" />
                                    <span class="form-check-label fw-bold text-gray-400">Allowed</span>
                                </label>
                                <!--end::Switch-->
                            </div>
                            <!--end::Notice-->
                        </div>
                        <!--end::Modal body-->
                    </div>
                    <!--end::Modal content-->
                </div>
                <!--end::Modal dialog-->
            </div>
            <!--end::Modal - View Users-->
            <!--begin::Modal - Users Search-->
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
                                <h1 class="mb-3">Search Users</h1>
                                <div class="text-gray-400 fw-bold fs-5">Invite Collaborators To Your Project</div>
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
                                    <input type="text" class="form-control form-control-lg form-control-solid px-15" name="search" value="" placeholder="Search by username, full name or email..." data-kt-search-element="input" />
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
                                        <!--end::Svg Icon-->
														</span>
                                    <!--end::Reset-->
                                </form>
                                <!--end::Form-->
                                <!--begin::Wrapper-->
                                <div class="py-5">
                                    <!--begin::Suggestions-->
                                    <div data-kt-search-element="suggestions">
                                        <!--begin::Heading-->
                                        <h3 class="fw-bold mb-5">Recently searched:</h3>
                                        <!--end::Heading-->
                                        <!--begin::Users-->
                                        <div class="mh-375px scroll-y me-n7 pe-7">
                                            <!--begin::User-->
                                            <a href="#" class="d-flex align-items-center p-3 rounded bg-state-light bg-state-opacity-50 mb-1">
                                                <!--begin::Avatar-->
                                                <div class="symbol symbol-35px symbol-circle me-5">
                                                    <img alt="Pic" src="assets/media/avatars/150-1.jpg" />
                                                </div>
                                                <!--end::Avatar-->
                                                <!--begin::Info-->
                                                <div class="fw-bold">
                                                    <span class="fs-6 text-gray-800 me-2">Emma Smith</span>
                                                    <span class="badge badge-light">Art Director</span>
                                                </div>
                                                <!--end::Info-->
                                            </a>
                                            <!--end::User-->
                                            <!--begin::User-->
                                            <a href="#" class="d-flex align-items-center p-3 rounded bg-state-light bg-state-opacity-50 mb-1">
                                                <!--begin::Avatar-->
                                                <div class="symbol symbol-35px symbol-circle me-5">
                                                    <span class="symbol-label bg-light-danger text-danger fw-bold">M</span>
                                                </div>
                                                <!--end::Avatar-->
                                                <!--begin::Info-->
                                                <div class="fw-bold">
                                                    <span class="fs-6 text-gray-800 me-2">Melody Macy</span>
                                                    <span class="badge badge-light">Marketing Analytic</span>
                                                </div>
                                                <!--end::Info-->
                                            </a>
                                            <!--end::User-->
                                            <!--begin::User-->
                                            <a href="#" class="d-flex align-items-center p-3 rounded bg-state-light bg-state-opacity-50 mb-1">
                                                <!--begin::Avatar-->
                                                <div class="symbol symbol-35px symbol-circle me-5">
                                                    <img alt="Pic" src="assets/media/avatars/150-2.jpg" />
                                                </div>
                                                <!--end::Avatar-->
                                                <!--begin::Info-->
                                                <div class="fw-bold">
                                                    <span class="fs-6 text-gray-800 me-2">Max Smith</span>
                                                    <span class="badge badge-light">Software Enginer</span>
                                                </div>
                                                <!--end::Info-->
                                            </a>
                                            <!--end::User-->
                                            <!--begin::User-->
                                            <a href="#" class="d-flex align-items-center p-3 rounded bg-state-light bg-state-opacity-50 mb-1">
                                                <!--begin::Avatar-->
                                                <div class="symbol symbol-35px symbol-circle me-5">
                                                    <img alt="Pic" src="assets/media/avatars/150-4.jpg" />
                                                </div>
                                                <!--end::Avatar-->
                                                <!--begin::Info-->
                                                <div class="fw-bold">
                                                    <span class="fs-6 text-gray-800 me-2">Sean Bean</span>
                                                    <span class="badge badge-light">Web Developer</span>
                                                </div>
                                                <!--end::Info-->
                                            </a>
                                            <!--end::User-->
                                            <!--begin::User-->
                                            <a href="#" class="d-flex align-items-center p-3 rounded bg-state-light bg-state-opacity-50 mb-1">
                                                <!--begin::Avatar-->
                                                <div class="symbol symbol-35px symbol-circle me-5">
                                                    <img alt="Pic" src="assets/media/avatars/150-15.jpg" />
                                                </div>
                                                <!--end::Avatar-->
                                                <!--begin::Info-->
                                                <div class="fw-bold">
                                                    <span class="fs-6 text-gray-800 me-2">Brian Cox</span>
                                                    <span class="badge badge-light">UI/UX Designer</span>
                                                </div>
                                                <!--end::Info-->
                                            </a>
                                            <!--end::User-->
                                        </div>
                                        <!--end::Users-->
                                    </div>
                                    <!--end::Suggestions-->
                                    <!--begin::Results(add d-none to below element to hide the users list by default)-->
                                    <div data-kt-search-element="results" class="d-none">
                                        <!--begin::Users-->
                                        <div class="mh-375px scroll-y me-n7 pe-7">
                                            <!--begin::User-->
                                            <div class="rounded d-flex flex-stack bg-active-lighten p-4" data-user-id="0">
                                                <!--begin::Details-->
                                                <div class="d-flex align-items-center">
                                                    <!--begin::Checkbox-->
                                                    <label class="form-check form-check-custom form-check-solid me-5">
                                                        <input class="form-check-input" type="checkbox" name="users" data-kt-check="true" data-kt-check-target="[data-user-id='0']" value="0" />
                                                    </label>
                                                    <!--end::Checkbox-->
                                                    <!--begin::Avatar-->
                                                    <div class="symbol symbol-35px symbol-circle">
                                                        <img alt="Pic" src="assets/media/avatars/150-1.jpg" />
                                                    </div>
                                                    <!--end::Avatar-->
                                                    <!--begin::Details-->
                                                    <div class="ms-5">
                                                        <a href="#" class="fs-5 fw-bolder text-gray-900 text-hover-primary mb-2">Emma Smith</a>
                                                        <div class="fw-bold text-gray-400">e.smith@kpmg.com.au</div>
                                                    </div>
                                                    <!--end::Details-->
                                                </div>
                                                <!--end::Details-->
                                                <!--begin::Access menu-->
                                                <div class="ms-2 w-100px">
                                                    <select class="form-select form-select-solid form-select-sm" data-control="select2" data-hide-search="true">
                                                        <option value="1">Guest</option>
                                                        <option value="2" selected="selected">Owner</option>
                                                        <option value="3">Can Edit</option>
                                                    </select>
                                                </div>
                                                <!--end::Access menu-->
                                            </div>
                                            <!--end::User-->
                                            <!--begin::Separator-->
                                            <div class="border-bottom border-gray-300 border-bottom-dashed"></div>
                                            <!--end::Separator-->
                                            <!--begin::User-->
                                            <div class="rounded d-flex flex-stack bg-active-lighten p-4" data-user-id="1">
                                                <!--begin::Details-->
                                                <div class="d-flex align-items-center">
                                                    <!--begin::Checkbox-->
                                                    <label class="form-check form-check-custom form-check-solid me-5">
                                                        <input class="form-check-input" type="checkbox" name="users" data-kt-check="true" data-kt-check-target="[data-user-id='1']" value="1" />
                                                    </label>
                                                    <!--end::Checkbox-->
                                                    <!--begin::Avatar-->
                                                    <div class="symbol symbol-35px symbol-circle">
                                                        <span class="symbol-label bg-light-danger text-danger fw-bold">M</span>
                                                    </div>
                                                    <!--end::Avatar-->
                                                    <!--begin::Details-->
                                                    <div class="ms-5">
                                                        <a href="#" class="fs-5 fw-bolder text-gray-900 text-hover-primary mb-2">Melody Macy</a>
                                                        <div class="fw-bold text-gray-400">melody@altbox.com</div>
                                                    </div>
                                                    <!--end::Details-->
                                                </div>
                                                <!--end::Details-->
                                                <!--begin::Access menu-->
                                                <div class="ms-2 w-100px">
                                                    <select class="form-select form-select-solid form-select-sm" data-control="select2" data-hide-search="true">
                                                        <option value="1" selected="selected">Guest</option>
                                                        <option value="2">Owner</option>
                                                        <option value="3">Can Edit</option>
                                                    </select>
                                                </div>
                                                <!--end::Access menu-->
                                            </div>
                                            <!--end::User-->
                                            <!--begin::Separator-->
                                            <div class="border-bottom border-gray-300 border-bottom-dashed"></div>
                                            <!--end::Separator-->
                                            <!--begin::User-->
                                            <div class="rounded d-flex flex-stack bg-active-lighten p-4" data-user-id="2">
                                                <!--begin::Details-->
                                                <div class="d-flex align-items-center">
                                                    <!--begin::Checkbox-->
                                                    <label class="form-check form-check-custom form-check-solid me-5">
                                                        <input class="form-check-input" type="checkbox" name="users" data-kt-check="true" data-kt-check-target="[data-user-id='2']" value="2" />
                                                    </label>
                                                    <!--end::Checkbox-->
                                                    <!--begin::Avatar-->
                                                    <div class="symbol symbol-35px symbol-circle">
                                                        <img alt="Pic" src="assets/media/avatars/150-2.jpg" />
                                                    </div>
                                                    <!--end::Avatar-->
                                                    <!--begin::Details-->
                                                    <div class="ms-5">
                                                        <a href="#" class="fs-5 fw-bolder text-gray-900 text-hover-primary mb-2">Max Smith</a>
                                                        <div class="fw-bold text-gray-400">max@kt.com</div>
                                                    </div>
                                                    <!--end::Details-->
                                                </div>
                                                <!--end::Details-->
                                                <!--begin::Access menu-->
                                                <div class="ms-2 w-100px">
                                                    <select class="form-select form-select-solid form-select-sm" data-control="select2" data-hide-search="true">
                                                        <option value="1">Guest</option>
                                                        <option value="2">Owner</option>
                                                        <option value="3" selected="selected">Can Edit</option>
                                                    </select>
                                                </div>
                                                <!--end::Access menu-->
                                            </div>
                                            <!--end::User-->
                                            <!--begin::Separator-->
                                            <div class="border-bottom border-gray-300 border-bottom-dashed"></div>
                                            <!--end::Separator-->
                                            <!--begin::User-->
                                            <div class="rounded d-flex flex-stack bg-active-lighten p-4" data-user-id="3">
                                                <!--begin::Details-->
                                                <div class="d-flex align-items-center">
                                                    <!--begin::Checkbox-->
                                                    <label class="form-check form-check-custom form-check-solid me-5">
                                                        <input class="form-check-input" type="checkbox" name="users" data-kt-check="true" data-kt-check-target="[data-user-id='3']" value="3" />
                                                    </label>
                                                    <!--end::Checkbox-->
                                                    <!--begin::Avatar-->
                                                    <div class="symbol symbol-35px symbol-circle">
                                                        <img alt="Pic" src="assets/media/avatars/150-4.jpg" />
                                                    </div>
                                                    <!--end::Avatar-->
                                                    <!--begin::Details-->
                                                    <div class="ms-5">
                                                        <a href="#" class="fs-5 fw-bolder text-gray-900 text-hover-primary mb-2">Sean Bean</a>
                                                        <div class="fw-bold text-gray-400">sean@dellito.com</div>
                                                    </div>
                                                    <!--end::Details-->
                                                </div>
                                                <!--end::Details-->
                                                <!--begin::Access menu-->
                                                <div class="ms-2 w-100px">
                                                    <select class="form-select form-select-solid form-select-sm" data-control="select2" data-hide-search="true">
                                                        <option value="1">Guest</option>
                                                        <option value="2" selected="selected">Owner</option>
                                                        <option value="3">Can Edit</option>
                                                    </select>
                                                </div>
                                                <!--end::Access menu-->
                                            </div>
                                            <!--end::User-->
                                            <!--begin::Separator-->
                                            <div class="border-bottom border-gray-300 border-bottom-dashed"></div>
                                            <!--end::Separator-->
                                            <!--begin::User-->
                                            <div class="rounded d-flex flex-stack bg-active-lighten p-4" data-user-id="4">
                                                <!--begin::Details-->
                                                <div class="d-flex align-items-center">
                                                    <!--begin::Checkbox-->
                                                    <label class="form-check form-check-custom form-check-solid me-5">
                                                        <input class="form-check-input" type="checkbox" name="users" data-kt-check="true" data-kt-check-target="[data-user-id='4']" value="4" />
                                                    </label>
                                                    <!--end::Checkbox-->
                                                    <!--begin::Avatar-->
                                                    <div class="symbol symbol-35px symbol-circle">
                                                        <img alt="Pic" src="assets/media/avatars/150-15.jpg" />
                                                    </div>
                                                    <!--end::Avatar-->
                                                    <!--begin::Details-->
                                                    <div class="ms-5">
                                                        <a href="#" class="fs-5 fw-bolder text-gray-900 text-hover-primary mb-2">Brian Cox</a>
                                                        <div class="fw-bold text-gray-400">brian@exchange.com</div>
                                                    </div>
                                                    <!--end::Details-->
                                                </div>
                                                <!--end::Details-->
                                                <!--begin::Access menu-->
                                                <div class="ms-2 w-100px">
                                                    <select class="form-select form-select-solid form-select-sm" data-control="select2" data-hide-search="true">
                                                        <option value="1">Guest</option>
                                                        <option value="2">Owner</option>
                                                        <option value="3" selected="selected">Can Edit</option>
                                                    </select>
                                                </div>
                                                <!--end::Access menu-->
                                            </div>
                                            <!--end::User-->
                                            <!--begin::Separator-->
                                            <div class="border-bottom border-gray-300 border-bottom-dashed"></div>
                                            <!--end::Separator-->
                                            <!--begin::User-->
                                            <div class="rounded d-flex flex-stack bg-active-lighten p-4" data-user-id="5">
                                                <!--begin::Details-->
                                                <div class="d-flex align-items-center">
                                                    <!--begin::Checkbox-->
                                                    <label class="form-check form-check-custom form-check-solid me-5">
                                                        <input class="form-check-input" type="checkbox" name="users" data-kt-check="true" data-kt-check-target="[data-user-id='5']" value="5" />
                                                    </label>
                                                    <!--end::Checkbox-->
                                                    <!--begin::Avatar-->
                                                    <div class="symbol symbol-35px symbol-circle">
                                                        <span class="symbol-label bg-light-warning text-warning fw-bold">M</span>
                                                    </div>
                                                    <!--end::Avatar-->
                                                    <!--begin::Details-->
                                                    <div class="ms-5">
                                                        <a href="#" class="fs-5 fw-bolder text-gray-900 text-hover-primary mb-2">Mikaela Collins</a>
                                                        <div class="fw-bold text-gray-400">mikaela@pexcom.com</div>
                                                    </div>
                                                    <!--end::Details-->
                                                </div>
                                                <!--end::Details-->
                                                <!--begin::Access menu-->
                                                <div class="ms-2 w-100px">
                                                    <select class="form-select form-select-solid form-select-sm" data-control="select2" data-hide-search="true">
                                                        <option value="1">Guest</option>
                                                        <option value="2" selected="selected">Owner</option>
                                                        <option value="3">Can Edit</option>
                                                    </select>
                                                </div>
                                                <!--end::Access menu-->
                                            </div>
                                            <!--end::User-->
                                            <!--begin::Separator-->
                                            <div class="border-bottom border-gray-300 border-bottom-dashed"></div>
                                            <!--end::Separator-->
                                            <!--begin::User-->
                                            <div class="rounded d-flex flex-stack bg-active-lighten p-4" data-user-id="6">
                                                <!--begin::Details-->
                                                <div class="d-flex align-items-center">
                                                    <!--begin::Checkbox-->
                                                    <label class="form-check form-check-custom form-check-solid me-5">
                                                        <input class="form-check-input" type="checkbox" name="users" data-kt-check="true" data-kt-check-target="[data-user-id='6']" value="6" />
                                                    </label>
                                                    <!--end::Checkbox-->
                                                    <!--begin::Avatar-->
                                                    <div class="symbol symbol-35px symbol-circle">
                                                        <img alt="Pic" src="assets/media/avatars/150-8.jpg" />
                                                    </div>
                                                    <!--end::Avatar-->
                                                    <!--begin::Details-->
                                                    <div class="ms-5">
                                                        <a href="#" class="fs-5 fw-bolder text-gray-900 text-hover-primary mb-2">Francis Mitcham</a>
                                                        <div class="fw-bold text-gray-400">f.mitcham@kpmg.com.au</div>
                                                    </div>
                                                    <!--end::Details-->
                                                </div>
                                                <!--end::Details-->
                                                <!--begin::Access menu-->
                                                <div class="ms-2 w-100px">
                                                    <select class="form-select form-select-solid form-select-sm" data-control="select2" data-hide-search="true">
                                                        <option value="1">Guest</option>
                                                        <option value="2">Owner</option>
                                                        <option value="3" selected="selected">Can Edit</option>
                                                    </select>
                                                </div>
                                                <!--end::Access menu-->
                                            </div>
                                            <!--end::User-->
                                            <!--begin::Separator-->
                                            <div class="border-bottom border-gray-300 border-bottom-dashed"></div>
                                            <!--end::Separator-->
                                            <!--begin::User-->
                                            <div class="rounded d-flex flex-stack bg-active-lighten p-4" data-user-id="7">
                                                <!--begin::Details-->
                                                <div class="d-flex align-items-center">
                                                    <!--begin::Checkbox-->
                                                    <label class="form-check form-check-custom form-check-solid me-5">
                                                        <input class="form-check-input" type="checkbox" name="users" data-kt-check="true" data-kt-check-target="[data-user-id='7']" value="7" />
                                                    </label>
                                                    <!--end::Checkbox-->
                                                    <!--begin::Avatar-->
                                                    <div class="symbol symbol-35px symbol-circle">
                                                        <span class="symbol-label bg-light-danger text-danger fw-bold">O</span>
                                                    </div>
                                                    <!--end::Avatar-->
                                                    <!--begin::Details-->
                                                    <div class="ms-5">
                                                        <a href="#" class="fs-5 fw-bolder text-gray-900 text-hover-primary mb-2">Olivia Wild</a>
                                                        <div class="fw-bold text-gray-400">olivia@corpmail.com</div>
                                                    </div>
                                                    <!--end::Details-->
                                                </div>
                                                <!--end::Details-->
                                                <!--begin::Access menu-->
                                                <div class="ms-2 w-100px">
                                                    <select class="form-select form-select-solid form-select-sm" data-control="select2" data-hide-search="true">
                                                        <option value="1">Guest</option>
                                                        <option value="2" selected="selected">Owner</option>
                                                        <option value="3">Can Edit</option>
                                                    </select>
                                                </div>
                                                <!--end::Access menu-->
                                            </div>
                                            <!--end::User-->
                                            <!--begin::Separator-->
                                            <div class="border-bottom border-gray-300 border-bottom-dashed"></div>
                                            <!--end::Separator-->
                                            <!--begin::User-->
                                            <div class="rounded d-flex flex-stack bg-active-lighten p-4" data-user-id="8">
                                                <!--begin::Details-->
                                                <div class="d-flex align-items-center">
                                                    <!--begin::Checkbox-->
                                                    <label class="form-check form-check-custom form-check-solid me-5">
                                                        <input class="form-check-input" type="checkbox" name="users" data-kt-check="true" data-kt-check-target="[data-user-id='8']" value="8" />
                                                    </label>
                                                    <!--end::Checkbox-->
                                                    <!--begin::Avatar-->
                                                    <div class="symbol symbol-35px symbol-circle">
                                                        <span class="symbol-label bg-light-primary text-primary fw-bold">N</span>
                                                    </div>
                                                    <!--end::Avatar-->
                                                    <!--begin::Details-->
                                                    <div class="ms-5">
                                                        <a href="#" class="fs-5 fw-bolder text-gray-900 text-hover-primary mb-2">Neil Owen</a>
                                                        <div class="fw-bold text-gray-400">owen.neil@gmail.com</div>
                                                    </div>
                                                    <!--end::Details-->
                                                </div>
                                                <!--end::Details-->
                                                <!--begin::Access menu-->
                                                <div class="ms-2 w-100px">
                                                    <select class="form-select form-select-solid form-select-sm" data-control="select2" data-hide-search="true">
                                                        <option value="1" selected="selected">Guest</option>
                                                        <option value="2">Owner</option>
                                                        <option value="3">Can Edit</option>
                                                    </select>
                                                </div>
                                                <!--end::Access menu-->
                                            </div>
                                            <!--end::User-->
                                            <!--begin::Separator-->
                                            <div class="border-bottom border-gray-300 border-bottom-dashed"></div>
                                            <!--end::Separator-->
                                            <!--begin::User-->
                                            <div class="rounded d-flex flex-stack bg-active-lighten p-4" data-user-id="9">
                                                <!--begin::Details-->
                                                <div class="d-flex align-items-center">
                                                    <!--begin::Checkbox-->
                                                    <label class="form-check form-check-custom form-check-solid me-5">
                                                        <input class="form-check-input" type="checkbox" name="users" data-kt-check="true" data-kt-check-target="[data-user-id='9']" value="9" />
                                                    </label>
                                                    <!--end::Checkbox-->
                                                    <!--begin::Avatar-->
                                                    <div class="symbol symbol-35px symbol-circle">
                                                        <img alt="Pic" src="assets/media/avatars/150-6.jpg" />
                                                    </div>
                                                    <!--end::Avatar-->
                                                    <!--begin::Details-->
                                                    <div class="ms-5">
                                                        <a href="#" class="fs-5 fw-bolder text-gray-900 text-hover-primary mb-2">Dan Wilson</a>
                                                        <div class="fw-bold text-gray-400">dam@consilting.com</div>
                                                    </div>
                                                    <!--end::Details-->
                                                </div>
                                                <!--end::Details-->
                                                <!--begin::Access menu-->
                                                <div class="ms-2 w-100px">
                                                    <select class="form-select form-select-solid form-select-sm" data-control="select2" data-hide-search="true">
                                                        <option value="1">Guest</option>
                                                        <option value="2">Owner</option>
                                                        <option value="3" selected="selected">Can Edit</option>
                                                    </select>
                                                </div>
                                                <!--end::Access menu-->
                                            </div>
                                            <!--end::User-->
                                            <!--begin::Separator-->
                                            <div class="border-bottom border-gray-300 border-bottom-dashed"></div>
                                            <!--end::Separator-->
                                            <!--begin::User-->
                                            <div class="rounded d-flex flex-stack bg-active-lighten p-4" data-user-id="10">
                                                <!--begin::Details-->
                                                <div class="d-flex align-items-center">
                                                    <!--begin::Checkbox-->
                                                    <label class="form-check form-check-custom form-check-solid me-5">
                                                        <input class="form-check-input" type="checkbox" name="users" data-kt-check="true" data-kt-check-target="[data-user-id='10']" value="10" />
                                                    </label>
                                                    <!--end::Checkbox-->
                                                    <!--begin::Avatar-->
                                                    <div class="symbol symbol-35px symbol-circle">
                                                        <span class="symbol-label bg-light-danger text-danger fw-bold">E</span>
                                                    </div>
                                                    <!--end::Avatar-->
                                                    <!--begin::Details-->
                                                    <div class="ms-5">
                                                        <a href="#" class="fs-5 fw-bolder text-gray-900 text-hover-primary mb-2">Emma Bold</a>
                                                        <div class="fw-bold text-gray-400">emma@intenso.com</div>
                                                    </div>
                                                    <!--end::Details-->
                                                </div>
                                                <!--end::Details-->
                                                <!--begin::Access menu-->
                                                <div class="ms-2 w-100px">
                                                    <select class="form-select form-select-solid form-select-sm" data-control="select2" data-hide-search="true">
                                                        <option value="1">Guest</option>
                                                        <option value="2" selected="selected">Owner</option>
                                                        <option value="3">Can Edit</option>
                                                    </select>
                                                </div>
                                                <!--end::Access menu-->
                                            </div>
                                            <!--end::User-->
                                            <!--begin::Separator-->
                                            <div class="border-bottom border-gray-300 border-bottom-dashed"></div>
                                            <!--end::Separator-->
                                            <!--begin::User-->
                                            <div class="rounded d-flex flex-stack bg-active-lighten p-4" data-user-id="11">
                                                <!--begin::Details-->
                                                <div class="d-flex align-items-center">
                                                    <!--begin::Checkbox-->
                                                    <label class="form-check form-check-custom form-check-solid me-5">
                                                        <input class="form-check-input" type="checkbox" name="users" data-kt-check="true" data-kt-check-target="[data-user-id='11']" value="11" />
                                                    </label>
                                                    <!--end::Checkbox-->
                                                    <!--begin::Avatar-->
                                                    <div class="symbol symbol-35px symbol-circle">
                                                        <img alt="Pic" src="assets/media/avatars/150-7.jpg" />
                                                    </div>
                                                    <!--end::Avatar-->
                                                    <!--begin::Details-->
                                                    <div class="ms-5">
                                                        <a href="#" class="fs-5 fw-bolder text-gray-900 text-hover-primary mb-2">Ana Crown</a>
                                                        <div class="fw-bold text-gray-400">ana.cf@limtel.com</div>
                                                    </div>
                                                    <!--end::Details-->
                                                </div>
                                                <!--end::Details-->
                                                <!--begin::Access menu-->
                                                <div class="ms-2 w-100px">
                                                    <select class="form-select form-select-solid form-select-sm" data-control="select2" data-hide-search="true">
                                                        <option value="1" selected="selected">Guest</option>
                                                        <option value="2">Owner</option>
                                                        <option value="3">Can Edit</option>
                                                    </select>
                                                </div>
                                                <!--end::Access menu-->
                                            </div>
                                            <!--end::User-->
                                            <!--begin::Separator-->
                                            <div class="border-bottom border-gray-300 border-bottom-dashed"></div>
                                            <!--end::Separator-->
                                            <!--begin::User-->
                                            <div class="rounded d-flex flex-stack bg-active-lighten p-4" data-user-id="12">
                                                <!--begin::Details-->
                                                <div class="d-flex align-items-center">
                                                    <!--begin::Checkbox-->
                                                    <label class="form-check form-check-custom form-check-solid me-5">
                                                        <input class="form-check-input" type="checkbox" name="users" data-kt-check="true" data-kt-check-target="[data-user-id='12']" value="12" />
                                                    </label>
                                                    <!--end::Checkbox-->
                                                    <!--begin::Avatar-->
                                                    <div class="symbol symbol-35px symbol-circle">
                                                        <span class="symbol-label bg-light-info text-info fw-bold">A</span>
                                                    </div>
                                                    <!--end::Avatar-->
                                                    <!--begin::Details-->
                                                    <div class="ms-5">
                                                        <a href="#" class="fs-5 fw-bolder text-gray-900 text-hover-primary mb-2">Robert Doe</a>
                                                        <div class="fw-bold text-gray-400">robert@benko.com</div>
                                                    </div>
                                                    <!--end::Details-->
                                                </div>
                                                <!--end::Details-->
                                                <!--begin::Access menu-->
                                                <div class="ms-2 w-100px">
                                                    <select class="form-select form-select-solid form-select-sm" data-control="select2" data-hide-search="true">
                                                        <option value="1">Guest</option>
                                                        <option value="2">Owner</option>
                                                        <option value="3" selected="selected">Can Edit</option>
                                                    </select>
                                                </div>
                                                <!--end::Access menu-->
                                            </div>
                                            <!--end::User-->
                                            <!--begin::Separator-->
                                            <div class="border-bottom border-gray-300 border-bottom-dashed"></div>
                                            <!--end::Separator-->
                                            <!--begin::User-->
                                            <div class="rounded d-flex flex-stack bg-active-lighten p-4" data-user-id="13">
                                                <!--begin::Details-->
                                                <div class="d-flex align-items-center">
                                                    <!--begin::Checkbox-->
                                                    <label class="form-check form-check-custom form-check-solid me-5">
                                                        <input class="form-check-input" type="checkbox" name="users" data-kt-check="true" data-kt-check-target="[data-user-id='13']" value="13" />
                                                    </label>
                                                    <!--end::Checkbox-->
                                                    <!--begin::Avatar-->
                                                    <div class="symbol symbol-35px symbol-circle">
                                                        <img alt="Pic" src="assets/media/avatars/150-17.jpg" />
                                                    </div>
                                                    <!--end::Avatar-->
                                                    <!--begin::Details-->
                                                    <div class="ms-5">
                                                        <a href="#" class="fs-5 fw-bolder text-gray-900 text-hover-primary mb-2">John Miller</a>
                                                        <div class="fw-bold text-gray-400">miller@mapple.com</div>
                                                    </div>
                                                    <!--end::Details-->
                                                </div>
                                                <!--end::Details-->
                                                <!--begin::Access menu-->
                                                <div class="ms-2 w-100px">
                                                    <select class="form-select form-select-solid form-select-sm" data-control="select2" data-hide-search="true">
                                                        <option value="1">Guest</option>
                                                        <option value="2">Owner</option>
                                                        <option value="3" selected="selected">Can Edit</option>
                                                    </select>
                                                </div>
                                                <!--end::Access menu-->
                                            </div>
                                            <!--end::User-->
                                            <!--begin::Separator-->
                                            <div class="border-bottom border-gray-300 border-bottom-dashed"></div>
                                            <!--end::Separator-->
                                            <!--begin::User-->
                                            <div class="rounded d-flex flex-stack bg-active-lighten p-4" data-user-id="14">
                                                <!--begin::Details-->
                                                <div class="d-flex align-items-center">
                                                    <!--begin::Checkbox-->
                                                    <label class="form-check form-check-custom form-check-solid me-5">
                                                        <input class="form-check-input" type="checkbox" name="users" data-kt-check="true" data-kt-check-target="[data-user-id='14']" value="14" />
                                                    </label>
                                                    <!--end::Checkbox-->
                                                    <!--begin::Avatar-->
                                                    <div class="symbol symbol-35px symbol-circle">
                                                        <span class="symbol-label bg-light-success text-success fw-bold">L</span>
                                                    </div>
                                                    <!--end::Avatar-->
                                                    <!--begin::Details-->
                                                    <div class="ms-5">
                                                        <a href="#" class="fs-5 fw-bolder text-gray-900 text-hover-primary mb-2">Lucy Kunic</a>
                                                        <div class="fw-bold text-gray-400">lucy.m@fentech.com</div>
                                                    </div>
                                                    <!--end::Details-->
                                                </div>
                                                <!--end::Details-->
                                                <!--begin::Access menu-->
                                                <div class="ms-2 w-100px">
                                                    <select class="form-select form-select-solid form-select-sm" data-control="select2" data-hide-search="true">
                                                        <option value="1">Guest</option>
                                                        <option value="2" selected="selected">Owner</option>
                                                        <option value="3">Can Edit</option>
                                                    </select>
                                                </div>
                                                <!--end::Access menu-->
                                            </div>
                                            <!--end::User-->
                                            <!--begin::Separator-->
                                            <div class="border-bottom border-gray-300 border-bottom-dashed"></div>
                                            <!--end::Separator-->
                                            <!--begin::User-->
                                            <div class="rounded d-flex flex-stack bg-active-lighten p-4" data-user-id="15">
                                                <!--begin::Details-->
                                                <div class="d-flex align-items-center">
                                                    <!--begin::Checkbox-->
                                                    <label class="form-check form-check-custom form-check-solid me-5">
                                                        <input class="form-check-input" type="checkbox" name="users" data-kt-check="true" data-kt-check-target="[data-user-id='15']" value="15" />
                                                    </label>
                                                    <!--end::Checkbox-->
                                                    <!--begin::Avatar-->
                                                    <div class="symbol symbol-35px symbol-circle">
                                                        <img alt="Pic" src="assets/media/avatars/150-10.jpg" />
                                                    </div>
                                                    <!--end::Avatar-->
                                                    <!--begin::Details-->
                                                    <div class="ms-5">
                                                        <a href="#" class="fs-5 fw-bolder text-gray-900 text-hover-primary mb-2">Ethan Wilder</a>
                                                        <div class="fw-bold text-gray-400">ethan@loop.com.au</div>
                                                    </div>
                                                    <!--end::Details-->
                                                </div>
                                                <!--end::Details-->
                                                <!--begin::Access menu-->
                                                <div class="ms-2 w-100px">
                                                    <select class="form-select form-select-solid form-select-sm" data-control="select2" data-hide-search="true">
                                                        <option value="1" selected="selected">Guest</option>
                                                        <option value="2">Owner</option>
                                                        <option value="3">Can Edit</option>
                                                    </select>
                                                </div>
                                                <!--end::Access menu-->
                                            </div>
                                            <!--end::User-->
                                            <!--begin::Separator-->
                                            <div class="border-bottom border-gray-300 border-bottom-dashed"></div>
                                            <!--end::Separator-->
                                            <!--begin::User-->
                                            <div class="rounded d-flex flex-stack bg-active-lighten p-4" data-user-id="16">
                                                <!--begin::Details-->
                                                <div class="d-flex align-items-center">
                                                    <!--begin::Checkbox-->
                                                    <label class="form-check form-check-custom form-check-solid me-5">
                                                        <input class="form-check-input" type="checkbox" name="users" data-kt-check="true" data-kt-check-target="[data-user-id='16']" value="16" />
                                                    </label>
                                                    <!--end::Checkbox-->
                                                    <!--begin::Avatar-->
                                                    <div class="symbol symbol-35px symbol-circle">
                                                        <span class="symbol-label bg-light-warning text-warning fw-bold">M</span>
                                                    </div>
                                                    <!--end::Avatar-->
                                                    <!--begin::Details-->
                                                    <div class="ms-5">
                                                        <a href="#" class="fs-5 fw-bolder text-gray-900 text-hover-primary mb-2">Mikaela Collins</a>
                                                        <div class="fw-bold text-gray-400">mikaela@pexcom.com</div>
                                                    </div>
                                                    <!--end::Details-->
                                                </div>
                                                <!--end::Details-->
                                                <!--begin::Access menu-->
                                                <div class="ms-2 w-100px">
                                                    <select class="form-select form-select-solid form-select-sm" data-control="select2" data-hide-search="true">
                                                        <option value="1">Guest</option>
                                                        <option value="2">Owner</option>
                                                        <option value="3" selected="selected">Can Edit</option>
                                                    </select>
                                                </div>
                                                <!--end::Access menu-->
                                            </div>
                                            <!--end::User-->
                                        </div>
                                        <!--end::Users-->
                                        <!--begin::Actions-->
                                        <div class="d-flex flex-center mt-15">
                                            <button type="reset" id="kt_modal_users_search_reset" data-bs-dismiss="modal" class="btn btn-active-light me-3">Cancel</button>
                                            <button type="submit" id="kt_modal_users_search_submit" class="btn btn-primary">Add Selected Users</button>
                                        </div>
                                        <!--end::Actions-->
                                    </div>
                                    <!--end::Results-->
                                    <!--begin::Empty-->
                                    <div data-kt-search-element="empty" class="text-center d-none">
                                        <!--begin::Message-->
                                        <div class="fw-bold py-10">
                                            <div class="text-gray-600 fs-3 mb-2">No users found</div>
                                            <div class="text-gray-400 fs-6">Try to search by username, full name or email...</div>
                                        </div>
                                        <!--end::Message-->
                                        <!--begin::Illustration-->
                                        <div class="text-center px-5">
                                            <img src="assets/media/illustrations/alert.png" alt="" class="mw-100 mh-200px" />
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
            <!--end::Modal - Users Search-->
            <!--end::Modals-->
        </div>
        <!--end::Container-->
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
    <script type="text/javascript" src="/js/project/show_message.js"></script>
@endsection
