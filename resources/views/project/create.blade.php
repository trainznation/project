@extends("layouts.app")

@section("styles")

@endsection

@section("bread")
    {{ Breadcrumbs::render('project_create') }}
@endsection

@section("content")
    <div class="container">
        <div class="card shadow-sm">
            <div class="card-header">
                <h3 class="card-title">Création d'un projet</h3>
            </div>
            <form action="{{ route('project.store') }}" method="post">
                @csrf
                <div class="card-body">
                    <div class="mb-10">
                        <label for="exampleFormControlInput1" class="required form-label">Titre du projet</label>
                        <input type="text" class="form-control form-control-solid form-control-lg" name="title" placeholder="Titre du projet" required/>
                    </div>
                    <div class="mb-10">
                        <label for="exampleFormControlInput1" class="required form-label">Courte description</label>
                        <textarea name="short_description" class="form-control form-control-lg form-control-solid" rows="3" placeholder="Maximum de 255 caractères" required></textarea>
                    </div>
                    <div class="mb-10">
                        <label for="exampleFormControlInput1" class="required form-label">Description</label>
                        <textarea name="description" class="form-control form-control-lg form-control-solid editor" rows="10" required></textarea>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Valider</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section("scripts")
    <script type="text/javascript" src="/plugins/custom/ckeditor/ckeditor-classic.bundle.js"></script>
    <script type="text/javascript" src="/js/project/create.js"></script>
@endsection
