@extends('layouts.app')

@section('title', 'Add New Book')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">Add New Book</div>
            <div class="card-body">
                <form action="{{ route('books.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" 
                               id="title" name="title" value="{{ old('title') }}" required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="summary" class="form-label">Summary</label>
                        <textarea class="form-control @error('summary') is-invalid @enderror" 
                                  id="summary" name="summary" rows="4" required>{{ old('summary') }}</textarea>
                        @error('summary')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="price" class="form-label">Price ($)</label>
                        <input type="number" step="0.01" class="form-control @error('price') is-invalid @enderror" 
                               id="price" name="price" value="{{ old('price') }}" required>
                        @error('price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="cover_image" class="form-label">Cover Image</label>
                        <input type="file" class="form-control @error('cover_image') is-invalid @enderror" 
                               id="cover_image" name="cover_image" accept="image/*" required>
                        @error('cover_image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="pdf_file" class="form-label">PDF File</label>
                        <input type="file" class="form-control @error('pdf_file') is-invalid @enderror" 
                               id="pdf_file" name="pdf_file" accept=".pdf" required>
                        @error('pdf_file')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">Add Book</button>
                        <a href="{{ route('books.index') }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection 