<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class Files extends Component
{
    public $files;
    public $obj ;

    public function __construct($files = [], $obj = null) {
        $this->files = $files;
        $this->obj = $obj;
    }

    public function deleteFile($fileName,$file)
    {
        unset($this->files[$fileName]);
        $this->obj->files = json_encode($this->files);
        Storage::delete($file);
        $this->obj->save();
    }

    public function render()
    {
        return view('livewire.files');
    }
}
