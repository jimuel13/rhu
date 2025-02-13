<x-layout>

    <div class="manage-window-card">
    {{-- sweet alert for error handling --}}
    @if ($errors->has('editWName'))
        <script type="text/javascript">
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: '{{ $errors->first('editWName') }}',
                timer: 3000, // Auto-close after 3 seconds
                showConfirmButton: false
            });
        </script>
    @endif

    @if ($errors->has('editPersonnel'))
        <script type="text/javascript">
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: '{{ $errors->first('editPersonnel') }}',
                timer: 3000, // Auto-close after 3 seconds
                showConfirmButton: false
            });
        </script>
    @endif

    @if ($errors->has('editSWName'))
        <script type="text/javascript">
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: '{{ $errors->first('editSWName') }}',
                timer: 3000,
                showConfirmButton: false
            });
        </script>
    @endif

    @if (session('sweetalert'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '{{ session('sweetalert') }}',
            });
        </script>
    @endif

        {{-- for manage window --}}
        <div class="card mw-table">
            <div class="mw-header">
                <div class="d-flex align-items-center">
                    <h4 class="mw-title">Patient Records</h4>
                    <input type="text" id="search" class="form-control" style="margin-left: 630px;" placeholder="Search..." />
                    <button class="mw-btn-add ms-auto" data-bs-toggle="modal" data-bs-target="#addLabPatientModal">
                        <i class="fa fa-plus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body mw-table-body">
                <!-- Add Modal -->
                <div class="modal fade rhu-modal" id="addLabPatientModal" tabindex="-1" aria-labelledby="addLabPatientLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <!-- Modal Header -->
                            <div class="modal-header">
                                <h5 class="modal-title font-semibold text-black" id="addLabPatientLabel">Appointment Record</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
            
                            <!-- Add Modal Form -->
                            <form id="addLabPatientForm" method="POST" action="/add-vax_patient_records" enctype="multipart/form-data">
                                @csrf
                                <div class="modal-body">
                                    <h6 class="mb-3">Vaccine Details</h6>
            
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label for="name" class="form-label">Name</label>
                                            <select class="form-select" name="name" id="name" required>
                                                <option value="" selected disabled>Select a Name</option>
                                                @foreach($appointments as $appointment)
                                                    <option value="{{ $appointment->name }}">{{ $appointment->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
            
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label for="sub_type" class="form-label">Vaccine Type</label>
                                            <input type="text" class="form-control w-100" name="sub_type" id="sub_type" readonly>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="dose_number" class="form-label">Dose Number</label>
                                            <input type="text" class="form-control w-100" name="dose_number" id="dose_number" required>
                                        </div>
                                    </div>
            
                                    <div class="row mb-3" style="display: none;">
                                        <div class="col-md-6">
                                            <label for="status" class="form-label">Status</label>
                                            <select class="form-select" name="status" id="status" required>
                                                <option selected value="Completed">Completed</option>
                                                <option value="Rejected">Rejected</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
            
                                <!-- Modal Footer -->
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary px-4">Save</button>
                                    <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Close</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            


                <!-- Manage Window Table -->
                <div class="table-responsive mw-table-content">
                    <table id="add-row" class="display table">
                        <thead>
                            <tr class="mw-column-name">
                                <th>Name</th>
                                <th>Vaccine type</th>
                                <th>Dose Number</th>
                               <th>Date</th>
                                <th>Status</th>
                                <th style="width: 10%">Action</th>
                            </tr>
                        </thead>
                        <tbody class="logs-column-body">
                            @php
                                // Define an array to map vaccine types to their full names
                                $vaccineTypes = [
                                    'hepatitis_b' => 'Hepatitis B',
                                    'measles_mumps_rubella' => 'Measles, Mumps, Rubella (MMR)',
                                    'chickenpox' => 'Chickenpox (Varicella)',
                                    'polio' => 'Polio',
                                    'tetanus' => 'Tetanus',
                                    'diphtheria' => 'Diphtheria',
                                    'hpv' => 'Human Papillomavirus (HPV)',
                                    'influenza' => 'Influenza (Flu)',
                                    'pneumococcal' => 'Pneumococcal',
                                    'covid_19' => 'COVID-19',
                                ];
                            @endphp
                            @if ($patients->isNotEmpty())
                                    @foreach ($patients as $patient)
                                        <tr class="mw-column-name">
                                            <td>{{ $patient->name }}</td>
                                            <td>{{ $vaccineTypes[$patient->sub_type] ?? $patient->sub_type }}</td>
                                            <td>{{ $patient->dose_number}}</td>
                                            {{-- <td>
                                                <span style="display: inline-block; max-width: 150px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                                    {{ asset('storage/' . $patient->result) }}
                                                </span>
                                                <a href="{{ asset('storage/' . $patient->result) }}" class="btn btn-primary btn-sm d-inline" download>Download Test Result</a>
                                            </td> --}}

                                            <td>{{ $patient->date }}</td>
                                            <td>{{ $patient->status }}</td>

                                            <td>
                                                <div class="form-button-action">
                                                    <!-- Delete Button -->
                                                    <button type="button" class="btn btn-link btn-danger" onclick="deleteLabPatient({{ $patient->id }})">
                                                        <i class="fa fa-times"><span class="mw-btn-edit-text">Delete</span></i>
                                                    </button>

                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr class="mw-column-name">
                                        <td colspan="3" class="text-center">No Patient available</td>
                                    </tr>
                                @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


    {{-- sweetalert for delete --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript">
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: '{{ session('success') }}', // Display the success message from the session
                timer: 3000, // Auto-close after 3 seconds
                showConfirmButton: false
            });
        @endif

        @if ($errors->has('editUsername'))
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: '{{ $errors->first() }}', // Display the first error message
                timer: 3000, // Auto-close after 3 seconds
                showConfirmButton: false
            });
        @endif
    </script>

    <script>
        document.getElementById('name').addEventListener('change', function () {
            const name = this.value;

            // Fetch the sub_type from the backend
            fetch(`/get-sub-type-vax/${encodeURIComponent(name)}`)
                .then(response => response.json())
                .then(data => {
                    if (data.sub_type) {
                        document.getElementById('sub_type').value = data.sub_type;
                    } else {
                        document.getElementById('sub_type').value = 'No data found';
                    }
                })
                .catch(error => {
                    console.error('Error fetching sub_type:', error);
                    document.getElementById('sub_type').value = 'Error fetching data';
                });
        });
    </script>


    {{-- delete --}}
    <script>
        // delete method
        function deleteLabPatient(clientId) {
            Swal.fire({
                title: 'Are you sure?',
                text: "This action cannot be undone!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Send an AJAX request to delete the client
                    fetch(`/delete-patient_records/${clientId}`, {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire(
                                'Deleted!',
                                'The client has been deleted.',
                                'success'
                            );
                            // Optionally refresh the page or update the UI
                            location.reload();
                        } else {
                            Swal.fire(
                                'Error!',
                                'Something went wrong while deleting the client.',
                                'error'
                            );
                        }
                    })
                    .catch(error => {
                        Swal.fire(
                            'Error!',
                            'An unexpected error occurred.',
                            'error'
                        );
                        console.error('Error:', error);
                    });
                }
            });
        }

    </script>

    {{-- INPUT VALIDATION --}}
    <script>
        // format input
        function formatInput(input) {
            // Remove leading spaces
            input.value = input.value.replace(/^\s+/g, '');

            // Replace multiple spaces with a single space
            input.value = input.value.replace(/\s+/g, ' ');

            // Convert to uppercase
            input.value = input.value.toUpperCase();
        }
    </script>

</x-layout>
