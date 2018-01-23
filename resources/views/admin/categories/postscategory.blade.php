@extends('admin.king')

@section('content')

    <div class="col-md-10 col-md-offset-1">
        <h2>Post Category</h2>
        <div class="col-md-9 m-t-50">
            <table class="table table-striped table-flip-scroll cf well">
                <thead class="table-header">
                <th>#</th>
                <th>Name</th>
                </thead>
                <tbody>
                @foreach($categories as $postCategory)
                    <tr>

                        <td>
                            {{ $postCategory->id }}
                        </td>
                        <td>
                            {{ $postCategory->name }}
                        </td>

                        <td>
                            <button class="btn btn-danger edit_post_category" data-val="{{ $postCategory->name }}" data-cid="{{ $postCategory->id }}"> -EDIT- </button>
                            <button class="btn btn-danger del_posts_category" data-cid="{{ $postCategory->id }}"> -DELETE- </button>
                        </td>

                    </tr>
                @endforeach
                </tbody>

            </table>
        </div>

        <div class="col-md-3 m-t-50 well">

         <form action="{{ route('postscategory.store') }}" method="post">
             <div class="form-group">
                 <label class="form-label" id="name" name="name">Name</label>
                 <div class="controls">
                     <input type="text" name="name" id="name" class="form-control">
                 </div>
             </div>

             <div class="col-md-12 m-b-50">
                 <button type="submit" class="btn btn-lg btn-primary"> ADD NEW CATEGORY</button>
                 <input type="hidden" name="_token" value="{{ Session::token() }}"/>
             </div>

         </form>
     </div>
</div>
@endsection