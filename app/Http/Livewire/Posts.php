<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Post;

class Posts extends Component
{
    public $posts, $titulo, $corpo, $post_id;
    public $isOpen = 0;

    public function render()
    {
        $this->posts = Post::all();
        return view('livewire.posts');
    }
    public function create()
    {
        $this->resetInputFields();
        $this->openModal();
    }
    public function openModal()
    {
        $this->isOpen = true;
    }
    public function closeModal()
    {
        $this->isOpen = false;
    }
    public function resetInputFields(){
        $this->titulo = '';
        $this->corpo = '';
        $this->post_id = '';
    }
    public function store()
    {
        $this->validate([
            'titulo' => 'required',
            'corpo' => 'required',
        ]);
        Post::updateOrCreate(['id' => $this->post_id], [
            'titulo' => $this->titulo,
            'corpo' => $this->corpo,
        ]);

        session()->flash('message',
        $this->post_id ? 'Post atualizado com sucesso.' : 'Post Criado com sucesso');

        $this->closeModal();
        $this->resetInputFields();
    }
    public function edit($id)
    {
        $post = Post::findOrFail($id);
        $this->post_id = $id;
        $this->titulo = $post->titulo;
        $this->corpo = $post->corpo;
    }
    public function delete($id)
    {
        Post::find($id)->delete();
        session()->flash('message', 'Post excluído com sucesso!');
    }
}
