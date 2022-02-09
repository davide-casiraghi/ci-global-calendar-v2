<?php

namespace App\Http\Livewire;

use Livewire\Component;

/**
 * Show the delete button used in most of the edit views.
 *
 * @author Davide Casiraghi
 */
class DeleteModel extends Component
{
    public $model;
    public $modelName;
    public $redirectRoute;
    public $showModal = false;

    public function mount($model, $modelName, $redirectRoute)
    {
        $this->model = $model;
        $this->modelName = $modelName;
        $this->redirectRoute = $redirectRoute;
    }

    public function render()
    {
        return view('livewire.delete-model');
    }

    public function delete()
    {
        $this->showModal = true;
    }

    public function confirmDelete()
    {
        $this->model->delete();
        $this->showModal = false;

        session()->flash('success', ucfirst($this->modelName) . ' deleted successfully');
        return redirect(route($this->redirectRoute));
    }

    public function close()
    {
        $this->showModal = false;
    }
}
