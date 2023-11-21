<div class="modal fade" id="showModal" tabindex="-1" role="dialog" aria-labelledby="showModalLabel" aria-hidden="true">
  
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="showModalLabel">Product</h5>
        </div>
        <div class="modal-body">
          <table class="table table-hover">
            <tr>
                <th>#</th>
                <th>Image</th>
                <th>Name</th>
                <th>Price</th> 
                <th>Sale</th> 
            </tr>
            <tr>
                {{-- <td>{{$product->id}}</td>
                <td>
                  @if($product->images->isNotEmpty())
                      <img src="{{ asset('upload/'.$product->images->first()->url) }}" alt="Product Image" width="100px" height="100px">
                      @else
                      <img src="{{ asset('upload/default.png') }}" alt="User Image" width="100px" height="100px">
                    @endif 
                </td>
                <td>{{$product->name}}</td>
                <td>{{$product->price}}</td>
                <td>{{$product->sale}}</td> --}}
            </tr>
          </table
        </div>
        <div class="modal-footer">
          <button type="button" class="btn bg-gradient-info" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn bg-gradient-primary">Save changes</button>
        </div>
      </div>
    </div>
</div>
