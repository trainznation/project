<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;use Illuminate\Support\Str;

class UserController extends Controller
{
    /**
     * @var User
     */
    private $user;

    /**
     * UserController constructor.
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * @param Request $request
     */
    public function searching(Request $request)
    {
        $users = $this->user->newQuery()->where('name', 'LIKE', '%'.$request->get('search').'%')
            ->orWhere('email', 'LIKE', '%'.$request->get('search').'%')
            ->where('id', '!==', $request->get('user_id'))
            ->get();

        ob_start();
        ?>
        <?php if($users->count() != 0): ?>
        <form action="<?= route('project.addUsers', $request->get('project_id')); ?>" method="post">
            <?php csrf_field(); ?>
            <div class="mh-375px scroll-y me-n7 pe-7">
                <?php foreach ($users as $user): ?>
                    <div class="rounded d-flex flex-stack bg-active-lighten p-4" data-user-id="{{ $user->id }}">
                        <!--begin::Details-->
                        <div class="d-flex align-items-center">
                            <!--begin::Checkbox-->
                            <label class="form-check form-check-custom form-check-solid me-5">
                                <input class="form-check-input" type="checkbox" name="users[]" data-kt-check="true" data-kt-check-target="[data-user-id='<?= $user->id; ?>>']" value="<?= $user->id; ?>" />
                            </label>
                            <!--end::Checkbox-->
                            <!--begin::Avatar-->
                            <div class="symbol symbol-35px symbol-circle">
                                <div class="symbol-label fs-2 fw-bold text-success"><?= Str::limit($user->name, 2, ''); ?></div>
                            </div>
                            <!--end::Avatar-->
                            <!--begin::Details-->
                            <div class="ms-5">
                                <a href="#" class="fs-5 fw-bolder text-gray-900 text-hover-primary mb-2"><?= $user->name; ?></a>
                                <div class="fw-bold text-gray-400"><?= $user->email; ?></div>
                            </div>
                            <!--end::Details-->
                        </div>
                        <!--end::Details-->
                    </div>
                    <!--end::User-->
                    <!--begin::Separator-->
                    <div class="border-bottom border-gray-300 border-bottom-dashed"></div>
                    <!--end::Separator-->
                <?php endforeach; ?>
            </div>
            <div class="d-flex flex-center mt-15">
                <button type="reset" id="kt_modal_users_search_reset" data-bs-dismiss="modal" class="btn btn-active-light me-3">Annuler</button>
                <button type="submit" id="kt_modal_users_search_submit" class="btn btn-primary">Ajouter les utilisateurs selectionner</button>
            </div>
        </form>
        <?php else: ?>
        <div data-kt-search-element="empty" class="text-center">
            <!--begin::Message-->
            <div class="fw-bold py-10">
                <div class="text-gray-600 fs-3 mb-2">Aucun utilisateur trouver</div>
                <div class="text-gray-400 fs-6">Essayer avec le nom ou l'adresse mail</div>
            </div>
            <!--end::Message-->
            <!--begin::Illustration-->
            <div class="text-center px-5">
                <img src="/media/illustrations/alert.png" alt="" class="mw-100 mh-200px" />
            </div>
            <!--end::Illustration-->
        </div>
        <?php endif; ?>
        <?php
        $content = ob_get_clean();

        return response()->json([
            "content" => $content,
            "count" => $users->count()
        ]);
    }
}
