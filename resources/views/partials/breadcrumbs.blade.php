@unless($breadcrumbs->isEmpty())
    <div class="toolbar breadcrumb" id="kt_toolbar">
        <!--begin::Container-->
        <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
            <!--begin::Page title-->
            <div data-kt-place="true" data-kt-place-mode="prepend" data-kt-place-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}" class="page-title d-flex align-items-center me-3 flex-wrap mb-5 mb-lg-0 lh-1">
                <!--begin::Title-->
                <h1 class="d-flex align-items-center text-dark fw-bolder my-1 fs-3">{{ $breadcrumbs->last()->title }}</h1>
                <!--end::Title-->
                <!--begin::Separator-->
                <span class="h-20px border-gray-200 border-start mx-4"></span>
                <!--end::Separator-->
                <!--begin::Breadcrumb-->
                <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
                    @foreach($breadcrumbs as $breadcrumb)
                        @if(!is_null($breadcrumb->url) && !$loop->last)
                            <li class="breadcrumb-item text-muted">{{ $breadcrumb->title }}</li>
                            <li class="breadcrumb-item">
                                <span class="bullet bg-gray-200 w-5px h-2px"></span>
                            </li>
                        @else
                            <li class="breadcrumb-item text-dark">{{ $breadcrumb->title }}</li>
                        @endif
                    @endforeach
                </ul>
                <!--end::Breadcrumb-->
            </div>
            <!--end::Page title-->
            <!--begin::Actions-->

            <!--<div class="d-flex align-items-center py-1">
                <a href="#" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_create_app" id="kt_toolbar_primary_button">Create</a>
            </div>-->
            <!--end::Actions-->
        </div>
        <!--end::Container-->
    </div>
@endunless
