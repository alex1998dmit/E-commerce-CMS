<div class="col-md-6 text-center">
    {{-- TODO: search what method should i use --}}
    <form action="{{ route('products.search') }}" method="POST" class="form-inline">
        {{ csrf_field() }}
        <div class="form-group mx-sm-3">
            <input class="form-control" id="product_param" name="param" type="text" placeholder="Поиск..">
        </div>
        <input type="submit" class="btn btn-info" value="Найти">
    </form>
</div>
