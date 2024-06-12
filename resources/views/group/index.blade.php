<x-app-layout>
    <div class="container mt-5">
        <h2>Chat Messages</h2>
        
        <!-- Button to Open the Modal -->
        <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createModal">
            Add New Group
        </button>
        
        <!-- The Modal for Adding New Entries -->
        <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createModalLabel">Add New Message</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="create-message-form" method="POST" action="{{ route('group.insert')}}" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="mb-3">
                                <label for="image" class="form-label">Image</label>
                                <input type="file" class="form-control" id="image" name="image" required>
                            </div>
                            <div class="mb-3">
                                <label for="max_user" class="form-label">Max User</label>
                                <input type="number" class="form-control" id="max_user" name="max_user" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Bootstrap Table -->
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Maximun User </th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="chat-table-body">
                @foreach ($groups as $index =>  $group)
                    <tr>
                        <td> {{ $index + 1 }} </td>
                        <td>{{ $group->name}} </td>
                        <td>{{ $group->max_user }}</td>
                        <td><a href="{{ route('group.delete',['id' => $group->id])}}" class="btn btn-danger btn-sm" >Delete</a> </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    
</x-app-layout>
