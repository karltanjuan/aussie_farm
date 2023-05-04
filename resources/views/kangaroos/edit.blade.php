@extends('kangaroos.master')

@section('title', 'Edit Kangaroo')

@section('main-content')
    
    <div class="row">
        <div class="col-md-10 mx-auto">
            <div class="card p-2 mt-5">
                <div class="container">
                    <h3>Edit Kangaroo</h3>
                    <div class="row mt-3">
                        <div class="col-md-3">
                             <div class="form-group">
                                <label for="name">Name *</label>
                                <input type="text" class="form-control" name="name" id="name" required value="{{$kangaroo->name}}" autocomplete="off">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                            <label for="nickname">Nickname</label>
                            <input type="text" class="form-control" name="name" id="nickname" value="{{$kangaroo->nickname}}" autocomplete="off">
                        </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="weight">Weight *</label>
                                <input type="number" step="0.01" class="form-control" name="weight" id="weight" required value="{{$kangaroo->weight}}" autocomplete="off">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="height">Height *</label>
                                <input type="number" step="0.01" class="form-control" name="height" id="height" required value="{{$kangaroo->height}}" autocomplete="off">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="gender">Gender *</label>
                                <select class="form-control" name="gender" id="gender" required>
                                    <option value="0" {{ $kangaroo->gender == 0 ? 'selected' : '' }}>Male</option>
                                    <option value="1" {{ $kangaroo->gender == 1 ? 'selected' : '' }}>Female</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                             <div class="form-group">
                                <label for="color">Color</label>
                                <input type="text" class="form-control" name="color" id="color" value="{{$kangaroo->color}}" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="friendliness">Friendliness</label>
                                <select class="form-control" id="friendliness">
                                    <option value="0" {{ $kangaroo->friendliness == 0 ? 'selected' : '' }}>Not Friendly</option>
                                    <option value="1" {{ $kangaroo->friendliness == 1 ? 'selected' : '' }}>Friendly</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="birthday">Birthday *</label>
                                <input type="date" class="form-control" name="birthday" id="birthday" required value="{{$kangaroo->birthday}}" autocomplete="off">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                    </div>
            
                    
                    <button type="button" class="mt-3 btn btn-outline-info float-end" id="btn-update">Update Kangaroo</button>
                    <button type="button" class="mt-3 me-3 btn btn-outline-secondary float-end" id="btn-back"><i class="fas fa-angle-left"></i></button>
                </div>
            </div>
        </div>
    </div>

    <!-- Success modal -->
    <div class="modal fade" id="success-modal" tabindex="-1" aria-labelledby="success-modal-label" aria-hidden="true">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="success-modal-label">Success</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            Kangaroo updated successfully
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Error modal -->
    <div class="modal fade" id="error-modal" tabindex="-1" aria-labelledby="error-modal-label" aria-hidden="true">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="error-modal-label">Error</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            Something went wrong
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>



    <script>
        $(document).ready(function() {
        })

        $(document).on('click', '#btn-back', function() {
        	window.location.href = '{{url('kangaroos')}}';
        })


        function validateKangaroo(id, name, weight, height, birthday) {
            var is_valid = true;

            if (name === '') {
              $('#name').addClass('is-invalid');
              $('#name + .invalid-feedback').show().text('Name is required');
              $('')
              is_valid = false;
            } else {

                axios.post('{{url('kangaroos/validate-name')}}', { id: id, name: name })
                .then(function(response) {
                  if (response.data.status === 1) {
                    $('#name').addClass('is-invalid');
                    $('#name + .invalid-feedback').show().text('Name must be unique');

                    is_valid = false;
                  } else {
                    $('#name').removeClass('is-invalid');
                    $('#name + .invalid-feedback').hide();
                  }
                })
                // .catch(function() {
                //   console.log('Error checking name');
                //   is_valid = false;
                // });
            }

            if (isNaN(weight) || parseFloat(weight) <= 0 || weight == '') {
              $('#weight').addClass('is-invalid');
              $('#weight + .invalid-feedback').show().text('Weight is required')
              is_valid = false;
            } else {
              $('#weight').removeClass('is-invalid');
              $('#weight + .invalid-feedback').hide()
            }

            if (isNaN(height) || parseFloat(height) <= 0 || height == '') {
              $('#height').addClass('is-invalid');
              $('#height + .invalid-feedback').show().text('Height is required')
              is_valid = false;
            } else {
              $('#height').removeClass('is-invalid');
              $('#height + .invalid-feedback').hide()
            }

            if (birthday == '') {
              $('#birthday').addClass('is-invalid');
              $('#birthday + .invalid-feedback').show().text('Birthday is required')
              is_valid = false;
            } else {
              $('#birthday').removeClass('is-invalid');
              $('#birthday + .invalid-feedback').hide()
            }

            return is_valid;

        }

        $(document).on('click', '#btn-update', function() {
            var _token       = "{{csrf_token()}}";
            var id 		     = parseInt("{{$kangaroo->id}}");
            var name         = $('#name').val();
            var nickname     = $('#nickname').val();
            var weight       = $('#weight').val();
            var height       = $('#height').val();
            var gender       = $('#gender').val();
            var color        = $('#color').val();
            var friendliness = $('#friendliness').val();
            var birthday     = $('#birthday').val();


            if (!validateKangaroo(id, name, weight, height, birthday)) {
              return false;
            }

            axios.post('{{url('kangaroos')}}/{{$kangaroo->id}}', {
                name: name,
                nickname: nickname,
                weight: weight,
                height: height,
                gender: gender,
                color: color,
                friendliness: friendliness,
                birthday: birthday
            })
            .then(function(response) {
                if (response.data.status === 1) {
                    $('#success-modal').modal('show');
                    setTimeout(function() {
                        window.location.href = '{{url('kangaroos')}}';
                    }, 3000)
                } else {
                    $('#error-modal').modal('show');
                    setTimeout(function() {
                        window.location.href = '{{url('kangaroos/edit')}}';
                    }, 3000)
                }
            })
            // .catch(function(error) {
            //     console.log(error);
            // });

        })

    </script>
@endsection