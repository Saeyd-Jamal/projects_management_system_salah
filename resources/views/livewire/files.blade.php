
@php
    function getFileTypeIcon($filename) {
        $extension = pathinfo($filename, PATHINFO_EXTENSION);
        switch ($extension) {
            case 'jpg':
            case 'jpeg':
            case 'png':
            case 'gif':
                return '/storage/' . $filename;
            case 'pdf':
                return '/img/pdf-thumbnail.png';
            case 'xlsx':
            case 'xls':
                return '/img/excel-icon.png';
            case 'docx':
            case 'doc':
                return '/img/word-icon.png';
            default:
                return '/img/file-solid.svg';
        }
    }
@endphp
@push('styles')
<style>
    .file-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
        gap: 15px;
    }
    .file-item {
        position: relative;
        text-align: center;
        border: 1px solid #ddd;
        border-radius: 8px;
        overflow: hidden;
        transition: transform 0.3s;
    }
    .file-item:hover {
        transform: scale(1.05);
    }
    .file-thumbnail {
        width: 100%;
        height: 150px;
        object-fit: cover;
    }
    .file-name {
        padding: 10px;
        background: #f8f8f8;
        font-size: 14px;
        color: #333;
    }
    .file-item button {
        position: absolute;
        top: -150px;
        right: 0px;

        background-image: linear-gradient(310deg, #7928CA 0%, #FF0080 100%) !important;
        width: 27px;
        height: 27px;
        padding: 0;
        border-radius: 50%;
        font-size: 13px;
        cursor: pointer;
        transition: all 0.5s;
    }
    .file-item:hover button {
        top: 4px;
        right: 3px;
    }
</style>
@endpush

<div class="row mt-5" style="box-shadow: 5px 5px 23px -4px rgba(168, 168, 168, 0.86);border-radius: 6px;margin-right: 0px;padding: 19px 15px;">
    <h2 class="text-center">معاينة الملفات</h2>
    <div class="file-grid">
        @foreach ($files as $fileName => $file)
        <div class="file-item"  style="position: relative;">
            <button class="btn btn-danger" x-data x-on:click="$wire.deleteFile('{{ $fileName }}', '{{ $file }}')">
                <i class="fa-solid fa-x"></i>
            </button>
            <a href="{{asset('storage/' . $file)}}" target="_blank">
                <img src="{{getFileTypeIcon($file)}}" alt="{{$fileName}}" class="file-thumbnail p-2">
                <div class="file-name">{{$loop->iteration . "-" . $fileName}}</div>
            </a>
        </div>
        @endforeach
    </div>
</div>
