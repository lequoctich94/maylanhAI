@extends('layouts.admin')

@section('title', 'Quản lý Slider')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Quản lý Slider</h1>
        <a href="{{ route('admin.slides.create') }}" class="btn btn-primary">Thêm Slide Mới</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Hình ảnh</th>
                        <th>Tiêu đề</th>
                        <th>Thứ tự</th>
                        <th>Trạng thái</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($slides as $slide)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            <img src="{{ Storage::url($slide->image) }}" 
                                alt="{{ $slide->title }}" 
                                style="max-width: 100px;">
                        </td>
                        <td>{{ $slide->title }}</td>
                        <td>{{ $slide->order }}</td>
                        <td>
                            <span class="badge {{ $slide->status ? 'bg-success' : 'bg-danger' }}">
                                {{ $slide->status ? 'Hiện' : 'Ẩn' }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('admin.slides.edit', $slide) }}" 
                                class="btn btn-sm btn-info">Sửa</a>
                            <form action="{{ route('admin.slides.destroy', $slide) }}" 
                                method="POST" 
                                class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                    class="btn btn-sm btn-danger" 
                                    onclick="return confirm('Bạn có chắc muốn xóa slide này?')">
                                    Xóa
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            
            {{ $slides->links() }}
        </div>
    </div>
</div>
@endsection 