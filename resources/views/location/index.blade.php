@extends('layouts.app')

@section('content')

    <div class="container py-5">
        <div class="row">
            <h5>Ajax CRUD operation in Laravel 8 and Google Map API</h5>
        </div>
        <div class="row">
            <div class="col-md-12">
                <h5>
                    Location Data
                    <button type="button" class="btn btn-success float-end" data-bs-toggle="modal"
                        data-bs-target="#AddLocationModal">Add Location</button>
                </h5>
                <hr>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover ">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Lat</th>
                                <th>Long</th>
                                <th>Desc</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    

    <div class="container ">
        <div class="row">
            
            <div id="map"></div>
        </div>
    </div>

    {{-- Add Modal --}}
    <div class="modal fade" id="AddLocationModal" tabindex="-1" aria-labelledby="AddLocationModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="AddLocationModalLabel">Add Location Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <ul id="save_msgList"></ul>

                    <div class="form-group mb-3">
                        <label for="">Name</label>
                        <input type="text" required class="name form-control">
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Lat</label>
                        <input type="text" required class="lat form-control">
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Long</label>
                        <input type="text" required class="long form-control">
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Desc</label>
                        <input type="text" required class="desc form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary add_location">Save</button>
                </div>

            </div>
        </div>
    </div>
    {{-- Edit Modal --}}
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit & Update Location Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">

                    <ul id="update_msgList"></ul>

                    <input type="hidden" id="stud_id" />

                    <div class="form-group mb-3">
                        <label for="">Name</label>
                        <input type="text" id="name" required class="form-control">
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Lat</label>
                        <input type="text" id="lat" required class="form-control">
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Long</label>
                        <input type="text" id="long" required class="form-control">
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Desc</label>
                        <input type="text" id="desc" required class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary update_location">Update</button>
                </div>

            </div>
        </div>
    </div>
    {{-- Edn- Edit Modal --}}

    {{-- Delete Modal --}}
    <div class="modal fade" id="DeleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Delete Location Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h4>Confirm to Delete Data ?</h4>
                    <input type="hidden" id="deleteing_id">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary delete_location">Yes Delete</button>
                </div>
            </div>
        </div>
    </div>
    {{-- End - Delete Modal --}}




@endsection


@section('scripts')
    <script>
        $(document).ready(function() {
            // index 
            fetch();

            function fetch() {
                $.ajax({
                    type: "GET",
                    url: "/fetch-location",
                    dataType: "json",
                    success: function(response) {
                        // console.log(response);
                        $('tbody').html("");
                        $.each(response.location, function(key, item) {
                            $('tbody').append('<tr>\
                                        <td>' + item.id + '</td>\
                                        <td>' + item.name + '</td>\
                                        <td>' + item.lat + '</td>\
                                        <td>' + item.long + '</td>\
                                        <td>' + item.desc + '</td>\
                                        <td><button type="button" value="' + item.id + '" class="btn btn-primary editbtn btn-sm">Edit</button></td>\
                                        <td><button type="button" value="' + item.id + '" class="btn btn-danger deletebtn btn-sm">Delete</button></td>\
                                    \</tr>');
                        });
                        
                    }
                });
            }
            // store 
            $(document).on('click', '.add_location', function(e) {
                e.preventDefault();

                $(this).text('Sending..');

                var data = {
                    'name': $('.name').val(),
                    'lat': $('.lat').val(),
                    'long': $('.long').val(),
                    'desc': $('.desc').val(),
                }

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: "POST",
                    url: "/location",
                    data: data,
                    dataType: "json",
                    success: function(response) {
                        // console.log(response);
                        if (response.status == 400) {
                            $('#save_msgList').html("");
                            $('#save_msgList').addClass('alert alert-danger');
                            $.each(response.errors, function(key, err_value) {
                                $('#save_msgList').append('<li>' + err_value + '</li>');
                            });
                            $('.add_location').text('Save');
                        } else {
                            $('#save_msgList').html("");
                            $('#success_message').addClass('alert alert-success');
                            $('#success_message').text(response.message);
                            $('#AddLocationModal').find('input').val('');
                            $('.add_location').text('Save');
                            $('#AddLocationModal').modal('hide');
                            fetch();
                            location.reload();
                        }
                    }
                });

            });

            // edit 
            $(document).on('click', '.editbtn', function(e) {
                e.preventDefault();
                var stud_id = $(this).val();
                // alert(stud_id);
                $('#editModal').modal('show');
                $.ajax({
                    type: "GET",
                    url: "/edit-location/" + stud_id,
                    success: function(response) {
                        if (response.status == 404) {
                            $('#success_message').addClass('alert alert-success');
                            $('#success_message').text(response.message);
                            $('#editModal').modal('hide');
                        } else {
                            // console.log(response.student.name);
                            $('#name').val(response.location.name);
                            $('#lat').val(response.location.lat);
                            $('#long').val(response.location.long);
                            $('#desc').val(response.location.desc);
                            $('#stud_id').val(stud_id);
                        }
                    }
                });
                $('.btn-close').find('input').val('');

            });
            //update
            $(document).on('click', '.update_location', function(e) {
                e.preventDefault();

                $(this).text('Updating..');
                var id = $('#stud_id').val();
                // alert(id);

                var data = {
                    'name': $('#name').val(),
                    'lat': $('#lat').val(),
                    'long': $('#long').val(),
                    'desc': $('#desc').val(),
                }

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: "PUT",
                    url: "/update-location/" + id,
                    data: data,
                    dataType: "json",
                    success: function(response) {
                        // console.log(response);
                        if (response.status == 400) {
                            $('#update_msgList').html("");
                            $('#update_msgList').addClass('alert alert-danger');
                            $.each(response.errors, function(key, err_value) {
                                $('#update_msgList').append('<li>' + err_value +
                                    '</li>');
                            });
                            $('.update_location').text('Update');
                        } else {
                            $('#update_msgList').html("");

                            $('#success_message').addClass('alert alert-success');
                            $('#success_message').text(response.message);
                            $('#editModal').find('input').val('');
                            $('.update_location').text('Update');
                            $('#editModal').modal('hide');
                            fetch();
                            location.reload();
                        }
                    }
                });

            });
            //delete
            $(document).on('click', '.deletebtn', function() {
                var stud_id = $(this).val();
                $('#DeleteModal').modal('show');
                $('#deleteing_id').val(stud_id);
            });

            $(document).on('click', '.delete_location', function(e) {
                e.preventDefault();

                $(this).text('Deleting..');
                var id = $('#deleteing_id').val();

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: "DELETE",
                    url: "/delete-location/" + id,
                    dataType: "json",
                    success: function(response) {
                        // console.log(response);
                        if (response.status == 404) {
                            $('#success_message').addClass('alert alert-success');
                            $('#success_message').text(response.message);
                            $('.delete_location').text('Yes Delete');
                        } else {
                            $('#success_message').html("");
                            $('#success_message').addClass('alert alert-success');
                            $('#success_message').text(response.message);
                            $('.delete_location').text('Yes Delete');
                            $('#DeleteModal').modal('hide');
                            fetch();
                            location.reload();
                        }
                    }
                });
            });

        });
    </script>
 <!-- Script Hiển Thị Location Lên GG MAP và MARKER. -->
    <!-- Async script executes immediately and must be after any DOM elements used in callback. -->
    <!--remenber to put your google map key-->
    <script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC-dFHYjTqEVLndbN2gdvXsx09jfJHmNc8&callback=initMap"></script>

    <script>
        // The following example creates five accessible and
        // focusable markers.
        function initMap() {
            const map = new google.maps.Map(document.getElementById("map"), {
                zoom: 12,
                center: {
                    lat: 10.823099,
                    lng: 106.629662
                },
            });
            // Set LatLng and title text for the markers. The first marker (Boynton Pass)
            // receives the initial focus when tab is pressed. Use arrow keys to
            // move between markers; press tab again to cycle through the map controls.
            const listmarker = [

                @foreach ($map as $item)
                    [{ lat: {{ $item->lat }}, lng: {{ $item->long }} }, "{{ $item->desc }}"],
                
                @endforeach


            ];
            // Create an info window to share between markers.
            const infoWindow = new google.maps.InfoWindow();
            // Create the markers.
            listmarker.forEach(([position, title], i) => {
                const marker = new google.maps.Marker({
                    position,
                    map,
                    title: `${i + 1}. ${title}`,
                    label: `${i + 1}`,
                    optimized: false,
                });
                // Add a click listener for each marker, and set up the info window.
                marker.addListener("click", () => {
                    infoWindow.close();
                    infoWindow.setContent(marker.getTitle());
                    infoWindow.open(marker.getMap(), marker);
                });
            });
        }
    </script>

@endsection
