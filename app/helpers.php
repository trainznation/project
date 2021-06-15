<?php
if (!function_exists('currentRoute')) {
    function currentRoute($route)
    {
        return Route::currentRouteNamed($route) ? 'active' : '';
    }
}
if (!function_exists('typeFile')) {
    function typeFile($type)
    {
        switch ($type) {
            case '3ds': return '3DS Max File';
            case '7z': return '7-Zip File';
            case 'ai': return 'Adobe Illustrator';
            case 'app': return 'Application';
            case 'asp': return 'Active Server Page';
            case 'bat': return 'Batch File';
            case 'c++': return 'C++ File';
            case 'csharp': return 'C# File';
            case 'css': return 'CSS File';
            case 'csv': return 'CSV File';
            case 'dat': return 'DATA File';
            case 'dll': return 'DLL File';
            case 'doc': return 'Microsoft Word File';
            case 'docx': return 'New Microsoft Word File';
            case 'dwg': return '2D-3D Othographique File';
            case 'eml': return 'Email File';
            case 'eps': return 'Postscript File';
            case 'exe': return 'Windows Executable File';
            case 'flv': return 'Adobe Flash Video File';
            case 'gif': return 'GIF Image File';
            case 'html': return 'Web File';
            case 'ics': return 'iCalendar File';
            case 'iso': return 'Optical Disc Image File';
            case 'jar': return 'Java Runtime File';
            case 'jpeg': return 'JPEG Image File';
            case 'jpg': return 'JPG Image File';
            case 'js': return 'Javascript File';
            case 'log': return 'Log System File';
            case 'lua': return 'LUA Programming Script File';
            case 'mdb': return 'Microsoft Access Base File';
            case 'mov': return 'Quicktime Movie File Based';
            case 'mp3': return 'Mpeg V3 File';
            case 'mp4': return 'Mpeg V4 File';
            case 'obj': return '3D Image Standard File';
            case 'otf': return 'Police File';
            case 'pdf': return 'PDF File';
            case 'php': return 'WebPoscript Language Programming File';
            case 'png': return 'PNG Image File';
            case 'ppt': return 'Microsoft Powerpoint File';
            case 'psd': return 'Adobe Photoshop File';
            case 'pub': return 'Microsoft Publisher File';
            case 'rar': return 'Zip Format File';
            case 'sql': return 'Database File';
            case 'srt': return 'Subtitle File';
            case 'svg': return 'Vector Graphic File';
            case 'tga': return 'Targa Image File';
            case 'ttf': return 'Police TTF File';
            case 'txt': return 'Text File';
            case 'wav': return 'Microsoft Sound Format File';
            case 'xls': return 'Microsoft Excel File';
            case 'xlsx': return 'New Microsoft Excel File';
            case 'xml': return 'Extensible Markup Language File';
            case 'zip': return 'Winzip File Format';
            default: return 'Unknown type File';
        }
    }
}
if (!function_exists('typeFileMime')) {
    function typeFileMime($type)
    {
        switch ($type) {

            case 'c++': return 'text/x-c++src';
            case 'csharp': return 'text/x-objectivec';
            case 'css': return 'text/css';
            case 'html': return 'text/html';
            case 'js': return 'text/javascript';
            case 'log': return 'text/mime';
            case 'lua': return 'text/x-lua';
            case 'php': return 'text/x-httpd-php';
            case 'sql': return 'text/x-sql';
            case 'txt': return 'text/mime';
            case 'xml': return 'text/html';
            default: return 'Unknown type File';
        }
    }
}

if(!function_exists('arrayTypeFile')) {
    function arrayTypeFile() {
        return [
            "3ds",
            "7z",
            "ai",
            "app",
            "asp",
            "bat",
            "c++",
            "csharp",
            "css",
            "csv",
            "dat",
            "dll",
            "doc",
            "docx",
            "dwg",
            "eml",
            "eps",
            "exe",
            "flv",
            "gif",
            "html",
            "ics",
            "iso",
            "jar",
            "jpeg",
            "jpg",
            "js",
            "log",
            "lua",
            "mdb",
            "mov",
            "mp3",
            "mp4",
            "obj",
            "otf",
            "pdf",
            "php",
            "png",
            "ppt",
            "psd",
            "pub",
            "rar",
            "sql",
            "srt",
            "svg",
            "tga",
            "ttf",
            "txt",
            "wav",
            "xls",
            "xlsx",
            "xml",
            "zip",
        ];
    }
}

if (!function_exists('stateLabelProject')) {
    function stateLabelProject($state, $text = false)
    {
        if ($text == false) {
            switch ($state) {
                case 0:
                    return '<span class="badge badge-light-warning fw-bolder me-auto px-4 py-3">En cours</span>';
                case 1:
                    return '<span class="badge badge-light-success fw-bolder me-auto px-4 py-3">Terminer</span>';
                case 2:
                    return '<span class="badge badge-light-danger fw-bolder me-auto px-4 py-3">Annuler</span>';
                case 3:
                    return '<span class="badge badge-light-info fw-bolder me-auto px-4 py-3">En attente</span>';
                default;
                    return null;
            }
        } else {
            switch ($state) {
                case 0:
                    return 'En cours';
                case 1:
                    return 'Terminer';
                case 2:
                    return 'Annuler';
                case 3:
                    return 'En attente';
                default;
                    return null;
            }
        }
    }
}

if (!function_exists('stateProgressStateTask')) {
    function stateProgressStateTask($project_id)
    {
        $project = new \App\Models\Project();
        $proj = $project->newQuery()->find($project_id);

        $terminate_task = $proj->tasks()->where('state', 1)->count();
        $all_task = $proj->tasks()->count();

        $percent = ($terminate_task / 100 * $all_task) * 10;
        $percent_format = number_format($percent, 0, '.', '');

        return '<div class="h-4px w-100 bg-light mb-5" data-bs-toggle="tooltip" title="Le projet est à ' . $percent_format . '% Compléter">
                        <div class="bg-primary rounded h-4px" role="progressbar" style="width: ' . $percent_format . '%" aria-valuenow="' . $percent . '" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>';
    }
}

if (!function_exists('stateTask')) {
    function stateTask($state, $formatting = false)
    {
        if($formatting == false) {
            switch ($state) {
                case 0:
                    return 'success';
                case 1:
                    return 'danger';
                default;
                    return null;
            }
        } else {
            switch ($state) {
                case 0:
                    return '<div class="badge badge-light-success">Ouvert</div>';
                case 1:
                    return '<div class="badge badge-light-danger">Fermer</div>';
                default;
                    return null;
            }
        }
    }
}

if (!function_exists('priorityTask')) {
    function priorityTask($state, $formatting = false)
    {
        if($formatting == false) {
            switch ($state) {
                case 0:
                    return 'Basse';
                case 1:
                    return 'Moyenne';
                case 2:
                    return 'Haute';
                default;
                    return null;
            }
        } else {
            switch ($state) {
                case 0:
                    return '<div class="badge badge-light-primary">Basse</div>';
                case 1:
                    return '<div class="badge badge-light-warning">Moyenne</div>';
                case 2:
                    return '<div class="badge badge-light-danger">Haute</div>';
                default;
                    return null;
            }
        }
    }
}

if (!function_exists('statePublishProject')) {
    function statePublishProject($state, $text = false)
    {
        if ($text == false) {
            switch ($state) {
                case 0:
                    return '<span class="badge badge-primary fw-bolder me-auto px-4 py-3">Corbeille</span>';
                case 1:
                    return '<span class="badge badge-danger fw-bolder me-auto px-4 py-3">Priver</span>';
                case 2:
                    return '<span class="badge badge-success fw-bolder me-auto px-4 py-3">Public</span>';
                default;
                    return null;
            }
        } else {
            switch ($state) {
                case 0:
                    return 'corbeille';
                case 1:
                    return 'priver';
                case 2:
                    return 'public';
                default;
                    return null;
            }
        }
    }
}

if(!function_exists('human_filesize')) {
    function human_filesize($size, $precision = 2) {
        $units = array('B','kB','MB','GB','TB','PB','EB','ZB','YB');
        $step = 1024;
        $i = 0;
        while (($size / $step) > 0.9) {
            $size = $size / $step;
            $i++;
        }
        return round($size, $precision).$units[$i];
    }
}
