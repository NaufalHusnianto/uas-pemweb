<x-app-layout>
    <div class="create-address px-10">


        <form method="POST" action="{{ route('address.store') }}">
            @csrf
            <div class="form-group py-2 ">
                <label class="control-label col-sm-3">Province:</label>
                <div class="col-sm-12">
                    <select class="form-control" name="province_id" id="province_id">
                        <option value="">-- Select Province --</option>
                        @foreach ($provinces as $province)
                            <option value="{{ $province->id }}">{{ $province->name }}</option>
                        @endforeach
                    </select>
                    <input type="hidden" name="province_name" id="province_name">
                </div>
            </div>
            <div class="form-group py-2">
                <label class="control-label col-sm-3">Regency:</label>
                <div class="col-sm-12">
                    <select class="form-control" name="regency_id" id="regency_id" disabled>
                        <option value="">-- Select Regency --</option>
                        @foreach ($regencies as $regency)
                            <option value="{{ $regency->id }}">{{ $regency->name }}</option>
                        @endforeach
                    </select>
                    <input type="hidden" name="regency_name" id="regency_name">
                </div>
            </div>
            <div class="form-group py-2">
                <label class="control-label col-sm-3">District:</label>
                <div class="col-sm-12">
                    <select class="form-control" name="district_id" id="district_id" disabled>
                        <option value="">-- Select District --</option>
                        @foreach ($districts as $district)
                            <option value="{{ $district->id }}">{{ $district->name }}</option>
                        @endforeach
                    </select>
                    <input type="hidden" name="district_name" id="district_name">
                </div>
            </div>
            <div class="form-group py-2">
                <label class="control-label col-sm-3">Village:</label>
                <div class="col-sm-12">
                    <select class="form-control" name="village_id" id="village_id" disabled>
                        <option value="">-- Select Village --</option>
                        @foreach ($villages as $village)
                            <option value="{{ $village->id }}">{{ $village->name }}</option>
                        @endforeach
                    </select>
                    <input type="hidden" name="village_name" id="village_name">
                </div>
            </div>
            <div class="form-group py-2">
                <label class="control-label col-sm-3">Detail Address:</label>
                <div class="col-sm-12">
                    <input type="text" class="form-control" name="detail_address" id="detail_address"
                        placeholder="Describe Your street name and house number of your address!" required>
                </div>
            </div>
            <div class="form-group ">
                <div class="col-sm-offset-3 col-sm-12 mt-3 flex justify-end">
                    <button type="submit"
                        class="btn btn-success bg-black text-white px-5 py-2 mb-5 rounded-md hover:bg-slate-500">Save</button>
                </div>
            </div>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
        crossorigin="anonymous"></script>

    <script>
        $(document).ready(function() {
            // Province Change
            $('#province_id').change(function() {
                var provinceId = $(this).val();
                if (provinceId) {
                    $('#regency_id').prop('disabled', false);
                    $('#province_name').val($("#province_id option:selected").text());

                    $.ajax({
                        url: '{{ route('getRegencies') }}',
                        type: 'GET',
                        data: {
                            province_id: provinceId
                        },
                        success: function(data) {
                            $('#regency_id').empty();
                            $('#regency_id').append(
                                '<option value="">-- Select Regency --</option>');
                            $.each(data, function(key, value) {
                                $('#regency_id').append('<option value="' + value.id +
                                    '">' + value.name + '</option>');
                            });

                            // Reset dependent dropdowns
                            $('#district_id').empty().prop('disabled', true);
                            $('#village_id').empty().prop('disabled', true);
                        }
                    });
                } else {
                    $('#regency_id').prop('disabled', true);
                    $('#district_id').prop('disabled', true);
                    $('#village_id').prop('disabled', true);
                }
            });

            // Regency Change
            $('#regency_id').change(function() {
                var regencyId = $(this).val();
                if (regencyId) {
                    $('#district_id').prop('disabled', false);
                    $('#regency_name').val($("#regency_id option:selected").text());

                    $.ajax({
                        url: '{{ route('getDistricts') }}',
                        type: 'GET',
                        data: {
                            regency_id: regencyId
                        },
                        success: function(data) {
                            $('#district_id').empty();
                            $('#district_id').append(
                                '<option value="">-- Select District --</option>');
                            $.each(data, function(key, value) {
                                $('#district_id').append('<option value="' + value.id +
                                    '">' + value.name + '</option>');
                            });

                            // Reset village dropdown
                            $('#village_id').empty().prop('disabled', true);
                        }
                    });
                } else {
                    $('#district_id').prop('disabled', true);
                    $('#village_id').prop('disabled', true);
                }
            });

            // District Change
            $('#district_id').change(function() {
                var districtId = $(this).val();
                if (districtId) {
                    $('#village_id').prop('disabled', false);
                    $('#district_name').val($("#district_id option:selected").text());

                    $.ajax({
                        url: '{{ route('getVillages') }}',
                        type: 'GET',
                        data: {
                            district_id: districtId
                        },
                        success: function(data) {
                            $('#village_id').empty();
                            $('#village_id').append(
                                '<option value="">-- Select Village --</option>');
                            $.each(data, function(key, value) {
                                $('#village_id').append('<option value="' + value.id +
                                    '">' + value.name + '</option>');
                            });
                        }
                    });
                } else {
                    $('#village_id').prop('disabled', true);
                }
            });

            // Village Change
            $('#village_id').change(function() {
                $('#village_name').val($("#village_id option:selected").text());
            });
        });
    </script>
</x-app-layout>
