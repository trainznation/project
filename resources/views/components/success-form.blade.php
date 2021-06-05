@props(['success'])

@if($success)
    <div class="alert alert-dismissible bg-success d-flex flex-column flex-sm-row w-100 p-5 mb-10">
        <!--begin::Icon-->
        <!--begin::Svg Icon | path: icons/duotone/Interface/Edit.svg-->
        <span class="svg-icon svg-icon-2hx svg-icon-light me-4 mb-5 mb-sm-0">
			<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
				<rect opacity="0.25" x="3" y="21" width="18" height="2" rx="1" fill="#191213"></rect>
				<path fill-rule="evenodd" clip-rule="evenodd" d="M4.08576 11.5L3.58579 12C3.21071 12.375 3 12.8838 3 13.4142V17C3 18.1045 3.89543 19 5 19H8.58579C9.11622 19 9.62493 18.7893 10 18.4142L10.5 17.9142L4.08576 11.5Z" fill="#121319"></path>
				<path fill-rule="evenodd" clip-rule="evenodd" d="M5.5 10.0858L11.5858 4L18 10.4142L11.9142 16.5L5.5 10.0858Z" fill="#121319"></path>
				<path opacity="0.25" fill-rule="evenodd" clip-rule="evenodd" d="M18.1214 1.70705C16.9498 0.535476 15.0503 0.535476 13.8787 1.70705L13 2.58576L19.4142 8.99997L20.2929 8.12126C21.4645 6.94969 21.4645 5.0502 20.2929 3.87862L18.1214 1.70705Z" fill="#191213"></path>
			</svg>
		</span>
        <!--end::Svg Icon-->
        <!--end::Icon-->
        <!--begin::Content-->
        <div class="d-flex flex-column text-light pe-0 pe-sm-10">
            <h5 class="mb-1">Succès</h5>
            {!! $success !!}
        </div>
        <!--end::Content-->
        <!--begin::Close-->
        <button type="button" class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto" data-bs-dismiss="alert">
            <!--begin::Svg Icon | path: icons/duotone/Navigation/Close.svg-->
            <span class="svg-icon svg-icon-2x svg-icon-light">
				<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
					<g transform="translate(12.000000, 12.000000) rotate(-45.000000) translate(-12.000000, -12.000000) translate(4.000000, 4.000000)" fill="#000000">
						<rect fill="#000000" x="0" y="7" width="16" height="2" rx="1"></rect>
						<rect fill="#000000" opacity="0.5" transform="translate(8.000000, 8.000000) rotate(-270.000000) translate(-8.000000, -8.000000)" x="0" y="7" width="16" height="2" rx="1"></rect>
					</g>
				</svg>
			</span>
            <!--end::Svg Icon-->
        </button>
        <!--end::Close-->
    </div>
@endif

