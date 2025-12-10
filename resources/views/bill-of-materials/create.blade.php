@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Add Bill of Materials</h3>

    <form action="{{ route('bill-of-materials.store') }}" method="post">
        @csrf

        <div class="mb-3">
            <label>Product</label>
            <select name="product_id" class="form-control" required>
                <option value="">-- Select Product --</option>
                @foreach($products as $product)
                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Reference</label>
            <input type="text" name="reference" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>BOM Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <hr>

        <h5>Components</h5>

        <table class="table table-bordered" id="bomTable">
            <thead>
                <tr>
                    <th>Product</th>
                    <th width="120px">Quantity</th>
                    <th width="150px">Unit Cost</th>
                    <th width="50px"></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <select name="items[0][product_id]" class="form-control" required>
                            <option value="">-- Select Product --</option>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}">{{ $product->name }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <input type="number" name="items[0][quantity]" class="form-control" required min="1">
                    </td>
                    <td>
                        <input type="number" step="0.01" name="items[0][cost]" class="form-control" required>
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger btn-sm remove-row">X</button>
                    </td>
                </tr>
            </tbody>
        </table>

        <button type="button" class="btn btn-success" id="addRow">+ Add Component</button>

        <hr>

        <button class="btn btn-primary">Save</button>
        <a href="{{ route('bill-of-materials.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>


<script>
    let rowIndex = 1;

    document.getElementById('addRow').addEventListener('click', function () {
        let table = document.querySelector('#bomTable tbody');
        let newRow = `
        <tr>
            <td>
                <select name="items[${rowIndex}][product_id]" class="form-control" required>
                    <option value="">-- Select Product --</option>
                    @foreach($products as $product)
                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                    @endforeach
                </select>
            </td>
            <td><input type="number" name="items[${rowIndex}][quantity]" class="form-control" min="1" required></td>
            <td><input type="number" step="0.01" name="items[${rowIndex}][cost]" class="form-control" required></td>
            <td><button type="button" class="btn btn-danger btn-sm remove-row">X</button></td>
        </tr>`;

        table.insertAdjacentHTML('beforeend', newRow);
        rowIndex++;
    });

    document.addEventListener('click', function(e) {
        if(e.target.classList.contains('remove-row')){
            e.target.closest('tr').remove();
        }
    });
</script>

@endsection
