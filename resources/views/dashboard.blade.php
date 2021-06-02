@extends("layouts.app")

@section("content")
    <div class="row g-6 g-xl-9">
        <div class="col-lg-12 col-xxl-12">
            <!--begin::Card-->
            <div class="card h-100">
                <!--begin::Card body-->
                <div class="card-body p-9">
                    <!--begin::Heading-->
                    <div class="fs-2hx fw-bolder">237</div>
                    <div class="fs-4 fw-bold text-gray-400 mb-7">Projets Actuelles</div>
                    <!--end::Heading-->
                    <!--begin::Wrapper-->
                    <div class="d-flex flex-wrap">
                        <!--begin::Chart-->
                        <div class="d-flex flex-center h-100px w-300px me-9 mb-5">
                            <canvas id="kt_project_list_chart" width="100" height="100" style="display: block; box-sizing: border-box; height: 100px; width: 100px;"></canvas>
                        </div>
                        <!--end::Chart-->
                        <!--begin::Labels-->
                        <div class="d-flex flex-column justify-content-center flex-row-fluid pe-11 mb-5">
                            <!--begin::Label-->
                            <div class="d-flex fs-6 fw-bold align-items-center mb-3">
                                <div class="bullet bg-primary me-3"></div>
                                <div class="text-gray-400">Active</div>
                                <div class="ms-auto fw-bolder text-gray-700">30</div>
                            </div>
                            <!--end::Label-->
                            <!--begin::Label-->
                            <div class="d-flex fs-6 fw-bold align-items-center mb-3">
                                <div class="bullet bg-success me-3"></div>
                                <div class="text-gray-400">Completed</div>
                                <div class="ms-auto fw-bolder text-gray-700">45</div>
                            </div>
                            <!--end::Label-->
                            <!--begin::Label-->
                            <div class="d-flex fs-6 fw-bold align-items-center">
                                <div class="bullet bg-gray-300 me-3"></div>
                                <div class="text-gray-400">Yet to start</div>
                                <div class="ms-auto fw-bolder text-gray-700">25</div>
                            </div>
                            <!--end::Label-->
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
        <!--begin::Controls-->
        <div class="d-flex flex-wrap my-1">
            <!--begin::Select wrapper-->
            <div class="m-0">
                <!--begin::Select-->
                <select name="status" data-control="select2" data-hide-search="true" class="form-select form-select-white form-select-sm fw-bolder w-125px">
                    <option value="in_progress" selected>En cours</option>
                    <option value="todo">A Faire</option>
                    <option value="close">Terminer</option>
                </select>
                <!--end::Select-->
            </div>
            <!--end::Select wrapper-->
        </div>
        <!--end::Controls-->
    </div>
    <div class="row g-6 g-xl-9">
        <!--begin::Col-->
        <div class="col-md-6 col-xl-4">
            <!--begin::Card-->
            <a href="pages/projects/project.html" class="card border border-2 border-gray-300 border-hover">
                <!--begin::Card header-->
                <div class="card-header border-0 pt-9">
                    <!--begin::Card Title-->
                    <div class="card-title m-0">
                        <!--begin::Avatar-->
                        <div class="symbol symbol-50px w-50px bg-light">
                            <img src="assets/media/svg/brand-logos/plurk.svg" alt="image" class="p-3" />
                        </div>
                        <!--end::Avatar-->
                    </div>
                    <!--end::Car Title-->
                    <!--begin::Card toolbar-->
                    <div class="card-toolbar">
                        <span class="badge badge-light-primary fw-bolder me-auto px-4 py-3">In Progress</span>
                    </div>
                    <!--end::Card toolbar-->
                </div>
                <!--end:: Card header-->
                <!--begin:: Card body-->
                <div class="card-body p-9">
                    <!--begin::Name-->
                    <div class="fs-3 fw-bolder text-dark">Fitnes App</div>
                    <!--end::Name-->
                    <!--begin::Description-->
                    <p class="text-gray-400 fw-bold fs-5 mt-1 mb-7">CRM App application to HR efficiency</p>
                    <!--end::Description-->
                    <!--begin::Info-->
                    <div class="d-flex flex-wrap mb-5">
                        <!--begin::Due-->
                        <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-7 mb-3">
                            <div class="fs-6 text-gray-800 fw-bolder">May 05, 2021</div>
                            <div class="fw-bold text-gray-400">Due Date</div>
                        </div>
                        <!--end::Due-->
                        <!--begin::Budget-->
                        <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 mb-3">
                            <div class="fs-6 text-gray-800 fw-bolder">$284,900.00</div>
                            <div class="fw-bold text-gray-400">Budget</div>
                        </div>
                        <!--end::Budget-->
                    </div>
                    <!--end::Info-->
                    <!--begin::Progress-->
                    <div class="h-4px w-100 bg-light mb-5" data-bs-toggle="tooltip" title="This project 50% completed">
                        <div class="bg-primary rounded h-4px" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <!--end::Progress-->
                    <!--begin::Users-->
                    <div class="symbol-group symbol-hover">
                        <!--begin::User-->
                        <div class="symbol symbol-35px symbol-circle" data-bs-toggle="tooltip" title="Emma Smith">
                            <img alt="Pic" src="assets/media/avatars/150-1.jpg" />
                        </div>
                        <!--begin::User-->
                        <!--begin::User-->
                        <div class="symbol symbol-35px symbol-circle" data-bs-toggle="tooltip" title="Rudy Stone">
                            <img alt="Pic" src="assets/media/avatars/150-2.jpg" />
                        </div>
                        <!--begin::User-->
                        <!--begin::User-->
                        <div class="symbol symbol-35px symbol-circle" data-bs-toggle="tooltip" title="Susan Redwood">
                            <span class="symbol-label bg-primary text-inverse-primary fw-bolder">S</span>
                        </div>
                        <!--begin::User-->
                    </div>
                    <!--end::Users-->
                </div>
                <!--end:: Card body-->
            </a>
            <!--end::Card-->
        </div>
        <!--end::Col-->
    </div>
@endsection
