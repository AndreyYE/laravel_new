@extends('layouts.app')

@section('content')
    @include('cabinet._nav',['page'=>'promo'])
    <form method="post" action="{{route('admin.promo.store',['advert'=>$advert])}}">
        @csrf
        <div class="row text-center align-items-center">
            <div class="col-md-2">
                <div class="form-group">
                    <label>Number of clicks</label>
                    <input name="quantity" type="number" class="form-control" min="10" value="10">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Cost one click (US)</label>
                    <input name="price" type="text" value="0.05" hidden>
                    <div class="border border-dark">0,05</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Total</label>
                    <input name="total" type="text" hidden >
                    <div id="total" class="border border-dark">{{env('PRICE_CLICK')*10}}</div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Pay</button>
                </div>
            </div>
        </div>
    </form>
@endsection
@section('scripts')
<script type="text/javascript">
    window.addEventListener('load',function(){

    $("input[name='quantity']").change(function (e) {
        let clicks = +($(this).val());
        let price = +($("input[name='price']").val());
        let total = (clicks*price).toFixed(2);
        $("input[name='total']").val(total);
        $("#total").text(total);
    })

    })
</script>
@endsection
