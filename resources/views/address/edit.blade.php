<x-app-layout>
    <form method="POST" action="{{ route('address.update', $address->id) }}">
        @csrf
        @method('PUT')
        <div class="form-group py-2">
            <label class="control-label col-sm-3">Province:</label>
            <div class="col-sm-12">
                <select class="form-control" name="province_id" id="province_id">
                    <option value="">-- Select Province --</option>
                    @foreach ($provinces as $province)
                        <option value="{{ $province->id }}" {{ $province->id == $address->province_id ? 'selected' : '' }}>
                            {{ $province->name }}
                        </option>
                    @endforeach
                </select>
                <input type="hidden" name="province_name" id="province_name" value="{{ $address->province_name }}">
            </div>
        </div>
        <div class="form-group py-2">
            <label class="control-label col-sm-3">Regency:</label>
            <div class="col-sm-12">
                <select class="form-control" name="regency_id" id="regency_id">
                    <option value="">-- Select Regency --</option>
                    @foreach ($regencies as $regency)
                        <option value="{{ $regency->id }}" {{ $regency->id == $address->regency_id ? 'selected' : '' }}>
                            {{ $regency->name }}
                        </option>
                    @endforeach
                </select>
                <input type="hidden" name="regency_name" id="regency_name" value="{{ $address->regency_name }}">
            </div>
        </div>
        <div class="form-group py-2">
            <label class="control-label col-sm-3">District:</label>
            <div class="col-sm-12">
                <select class="form-control" name="district_id" id="district_id">
                    <option value="">-- Select District --</option>
                    @foreach ($districts as $district)
                        <option value="{{ $district->id }}" {{ $district->id == $address->district_id ? 'selected' : '' }}>
                            {{ $district->name }}
                        </option>
                    @endforeach
                </select>
                <input type="hidden" name="district_name" id="district_name" value="{{ $address->district_name }}">
            </div>
        </div>
        <div class="form-group py-2">
            <label class="control-label col-sm-3">Village:</label>
            <div class="col-sm-12">
                <select class="form-control" name="village_id" id="village_id">
                    <option value="">-- Select Village --</option>
                    @foreach ($villages as $village)
                        <option value="{{ $village->id }}" {{ $village->id == $address->village_id ? 'selected' : '' }}>
                            {{ $village->name }}
                        </option>
                    @endforeach
                </select>
                <input type="hidden" name="village_name" id="village_name" value="{{ $address->village_name }}">
            </div>
        </div>
        <div class="form-group py-2">
            <label class="control-label col-sm-3">Detail Address:</label>
            <div class="col-sm-12">
                <input type="text" class="form-control" name="detail_address" id="detail_address"
                    placeholder="Describe Your street name and house number of your address!" 
                    value="{{ $address->detail_address }}" required>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-3 col-sm-12 mt-3">
                <button type="submit" class="btn btn-success">Update</button>
                <a href="{{ route('address.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </div>
    </form>

    <script>
        $(document).ready(function() {
            // Initialize hidden fields with current values
            $('#province_name').val($("#province_id option:selected").text());
            $('#regency_name').val($("#regency_id option:selected").text());
            $('#district_name').val($("#district_id option:selected").text());
            $('#village_name').val($("#village_id option:selected").text());

            // Province Change
            $('#province_id').change(function() {
                var provinceId = $(this).val();
                if(provinceId) {
                    $('#province_name').val($("#province_id option:selected").text());
                    
                    $.ajax({
                        url: '{{ route("getRegencies") }}',
                        type: 'GET',
                        data: { province_id: provinceId },
                        success: function(data) {
                            $('#regency_id').empty();
                            $('#regency_id').append('<option value="">-- Select Regency --</option>');
                            $.each(data, function(key, value) {
                                $('#regency_id').append('<option value="'+ value.id +'">'+ value.name +'</option>');
                            });
                            
                            // Reset dependent dropdowns
                            $('#district_id').empty();
                            $('#district_id').append('<option value="">-- Select District --</option>');
                            $('#village_id').empty();
                            $('#village_id').append('<option value="">-- Select Village --</option>');
                        }
                    });
                }
            });

            // Regency Change
            $('#regency_id').change(function() {
                var regencyId = $(this).val();
                if(regencyId) {
                    $('#regency_name').val($("#regency_id option:selected").text());
                    
                    $.ajax({
                        url: '{{ route("getDistricts") }}',
                        type: 'GET',
                        data: { regency_id: regencyId },
                        success: function(data) {
                            $('#district_id').empty();
                            $('#district_id').append('<option value="">-- Select District --</option>');
                            $.each(data, function(key, value) {
                                $('#district_id').append('<option value="'+ value.id +'">'+ value.name +'</option>');
                            });
                            
                            // Reset village dropdown
                            $('#village_id').empty();
                            $('#village_id').append('<option value="">-- Select Village --</option>');
                        }
                    });
                }
            });

            // District Change
            $('#district_id').change(function() {
                var districtId = $(this).val();
                if(districtId) {
                    $('#district_name').val($("#district_id option:selected").text());
                    
                    $.ajax({
                        url: '{{ route("getVillages") }}',
                        type: 'GET',
                        data: { district_id: districtId },
                        success: function(data) {
                            $('#village_id').empty();
                            $('#village_id').append('<option value="">-- Select Village --</option>');
                            $.each(data, function(key, value) {
                                $('#village_id').append('<option value="'+ value.id +'">'+ value.name +'</option>');
                            });
                        }
                    });
                }
            });

            // Village Change
            $('#village_id').change(function() {
                $('#village_name').val($("#village_id option:selected").text());
            });
        });
    </script>
</x-app-layout>