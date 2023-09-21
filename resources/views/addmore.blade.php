<tr>
    <td>
        <select name="extra_ids[{{$addmore}}]['stone']" class="form-control">
            <option value="">Select Product</option>
            @foreach($categorys as $cat) @if($cat->type == 'Stone')
            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
            @endif @endforeach
        </select>
    </td>
    <td>
        <select name="extra_ids[{{$addmore}}]['shape']" class="form-control">
            <option value="">Select Shape</option>
            @foreach($categorys as $cat) @if($cat->type == 'shape')
            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
            @endif @endforeach
        </select>
    </td>
    <td>
        <select name="extra_ids[{{$addmore}}]['size']" class="form-control">
            <option value="">Select Size</option>
            @foreach($categorys as $cat) @if($cat->type == 'size')
            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
            @endif @endforeach
        </select>
    </td>
    
    <td>
        <select name="extra_ids[{{$addmore}}]['quality']" class="form-control">
            <option value="">Select Quality</option>
            @foreach($categorys as $cat) @if($cat->type == 'quality')
            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
            @endif @endforeach
        </select>
    </td>
    <td>
       <input type="number" name="extra_ids[{{$addmore}}]['qty']" class="form-control" placeholder="Enter Qty." maxlength="5"/>
    </td>
    <td>
       <input type="text" name="extra_ids[{{$addmore}}]['height']" class="form-control" placeholder="Enter Height"/>
    </td>
   
    <td>
        <input type="text" name="extra_ids[{{$addmore}}]['remark']" class="form-control" placeholder="Enter Remark" />
    </td>
    <td><button type="button" class="btn btn-danger remove-tr">Remove</button></td>
</tr>
