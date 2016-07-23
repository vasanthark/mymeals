<tr>
    <th style="width: 20%">Meal Title</th>
    <th style="width: 35%">Items</th>
    <th style="width: 10%">Qty</th>
    <th style="width: 5%">Price</th>
    <th style="width: 5%">Grand Total</th>  
    <th style="width: 25%">Delivery date</th>
</tr>
@foreach ($datainfos as $key => $dayinfo)
<?php 
$day = $dayinfo->name;
$date_of_day = App\Helpers\MyFuncs::get_date($day);?>
<tr class="nmeal">
    <input type="hidden" value="{{ $dayinfo->meal_id }} " name="meal_id[{{$dayinfo->day_id}}]">
    <td><input type="hidden" value="{{ $dayinfo->meal->title }}" name="meal_title[{{$dayinfo->day_id}}]">{{ $dayinfo->meal->title }}</td>
    <td><input type="hidden" value="{{ implode(" , ", $dayinfo->meal->item()->lists("items.name")->toArray()) }}" name="meal_item[{{$dayinfo->day_id}}]">{{ implode(" , ", $dayinfo->meal->item()->lists("items.name")->toArray()) }}</td>
    <td><input type='number' value="1" name='qty[{{$dayinfo->day_id}}]' data-dayid="{{ $dayinfo->day_id }}"  class='form-control qtyclk' min="1"></td>    
    <td id="price_{{$dayinfo->day_id}}">{{ $dayinfo->price }}</td> 
    <td id="gtotal_{{$dayinfo->day_id}}">{{ $dayinfo->price }}</td>
    <td>
        <div class="input-group">
            <span class="input-group-addon"> <i class="fa fa-calendar"></i></span>            
        <input type='text' class='form-control date' value="{{ $date_of_day }}" name="meal_date[{{$dayinfo->day_id}}]">
        </div>                     
    </td>    
    <input type="hidden" value="{{ $dayinfo->price }}" name="subtotal[{{$dayinfo->day_id}}]">
    <input type="hidden" value="{{ $dayinfo->price }}" name="grandtotal[{{$dayinfo->day_id}}]">
</tr>
@endforeach