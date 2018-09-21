@inject('countries' , 'App\Http\Utilities\Country')
{{csrf_field()}}
    <div class="form-group">
        <label for="street">Street:</label>
        <input type="text" name="street" id="street" class="form-control" value="{{old('street')}}" required>
    </div>
    <div class="form-group">
        <label for="city">City:</label>
        <input type="text" name="city" id="city" class="form-control" value="{{old('city')}}" required>
    </div>
    <div class="form-group">
        <label for="zip">Zip/Postal/code:</label>
        <input type="text" name="zip" id="zip" class="form-control" value="{{old('zip')}}" required>
    </div>
    <div class="form-group">
        <label for="country">Country:</label>
        <select id="country" name="country" class="form-control" style="height: auto" required>
            @foreach($countries::all() as $country =>$code)
                <option value="{{$country}}">{{$code}}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label for="states">State:</label>
        <input name="states" id="states" class="form-control">
    </div>
    <div class="form-group">
        <label for="price">Sall Price:</label>
        <input type="text" name="price" id="price" class="form-control" value="{{old('price')}}" required>
    </div>

    <div class="form-group" style="height: auto">
        <label for="description">Description:</label>
        <textarea name="description" style="height: auto" id="description" cols="100" rows="10" value="{{old('price')}}"></textarea>
    </div>
    {{--<div class="form-group">--}}
        {{--<label for="photos">Photos:</label>--}}
        {{--<input type="file" class="form-control" id="photos" name="photos" value="" required>--}}
    {{--</div>--}}

    <div class="form-group">
        <button class="btn btn-primary" type="submit" > create flyer</button>
    </div>
