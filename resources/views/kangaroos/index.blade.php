@extends('kangaroos.master')

@section('title', 'Kangaroo List')

@section('main-content')

    <link rel="stylesheet" href="https://cdn3.devexpress.com/jslib/22.2.6/css/dx.light.css">
    
    <div class="row">
        <div class="col-md-10 mx-auto">
            
            <div class="card p-2 mt-5">
                <h3 class="mt-1 position-absolute" style="z-index:2;">Kangaroo List</h3>
                <button class="btn-add btn btn-sm mt-1 btn-outline-info position-absolute" style="z-index:2;margin-left: 180px"><i class="fas fa-plus text-dark"></i></button>
                <div class="kangaroo-list "></div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="delete-modal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="deleteModalLabel">Delete Confirmation</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            Are you sure you want to delete?
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-danger" id="confirm_delete">Delete</button>
          </div>
        </div>
      </div>
    </div>


    <div class="modal fade" id="success-modal" tabindex="-1" aria-labelledby="success-modal-label" aria-hidden="true">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="success-modal-label">Deleted</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            Kangaroo deleted successfully
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>

    <script type="text/javascript" src="https://cdn3.devexpress.com/jslib/22.2.6/js/dx.all.js"></script>


    <script>
        $(document).ready(function() {
            getKangaroos()
        })

        function getKangaroos()
        {

            var kangaroos = [];

            axios.get('{{ url('kangaroos/list') }}')
            .then(function (response) {
                kangaroos = response.data.map((item) => {
                  const modified_data = { ...item };

                  if (modified_data.gender === 0) {
                    modified_data.gender = 'Male';
                  } else if (modified_data.gender === 1) {
                    modified_data.gender = 'Female';
                  }

                  if (modified_data.friendliness === 0) {
                    modified_data.friendliness = 'Not friendly';
                  } else if (modified_data.friendliness === 1) {
                    modified_data.friendliness = 'Friendly';
                  }

                  return modified_data;
                });
                
                $(".kangaroo-list").dxDataGrid({
                  dataSource: kangaroos,
                  filterRow: { visible: true },
                  searchPanel: { visible: true },
                  repaintChangesOnly: true,
                  columnAutoWidth: true,
                  showBorders: true,
                  paging: {
                    pageSize: 10,
                  },
                  summary: {
                    groupItems: [{
                      summaryType: "count"
                    }]
                  },
                  columns: ['name', 'birthday', 'weight', 'height', 'friendliness', {
                    caption: "Action",
                    cellTemplate: function(container, options) {

                      // $("<button class='btn btn-sm btn-outline-success'>")
                      //   .attr("data-id", options.data.id)
                      //   .addClass("custom-button btn-edit")
                      //   .append($("<i>").addClass("fas fa-eye text-dark"))
                      //   .appendTo(container)

                      $("<button class='btn btn-sm btn-outline-info ms-2'>")
                        .attr("data-id", options.data.id)
                        .addClass("custom-button btn-edit")
                        .append($("<i>").addClass("fas fa-edit text-dark"))
                        .appendTo(container)
                        

                      $("<button class='btn btn-sm btn-outline-danger ms-2'>")
                        .attr("data-id", options.data.id)
                        .addClass("custom-button btn-delete")
                        .append($("<i>").addClass("fas fa-trash text-dark"))
                        .appendTo(container)
                    }
                  }],
                  
                });
            });
        }

        $(document).on('click', '.btn-add', function() {
            window.location.href = "{{url('/kangaroos/create')}}"
        })

        $(document).on('click', '.btn-edit', function() {
            var id = $(this).attr('data-id');
            window.location.href = `{{url('/kangaroos/${id}/edit')}}`
        })

        $(document).on('click', '.btn-delete', function() {
            var id = $(this).attr('data-id');
            $('#delete-modal').modal('show');
            $('#confirm_delete').data('id', id);
        });

        $(document).on('click', '#confirm_delete', function() {
            var id = $(this).data('id');
            axios.delete(`{{ url('kangaroos') }}/${id}`)
            .then(function (response) {
                if (response.data.status === 1) {
                  $('#delete-modal').hide()
                  $('#success-modal').modal('show');
                } else {
                  $('#delete-modal').hide()
                  $('#error-modal').modal('show');
                }

                setTimeout(function() {
                    window.location.href = '{{url('kangaroos')}}';
                }, 3000)
            });
        });

</script>

    </script>
@endsection