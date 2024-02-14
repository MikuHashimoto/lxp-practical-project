@extends('layouts.admin.app')

@section('content')
    <!-- Main content -->
    <section class="content">
    @include('layouts.errors-and-messages')
    <!-- Default box -->
        @if($reviews)
            <div class="box">
                <div class="box-body">
                    <h2>レビュー</h2>
                    @include('layouts.search', ['route' => route('admin.reviews.index')])
                    <table class="table">
                        <thead>
                            <tr>
                                <td>日時</td>
                                <td>商品ID</td>
                                <td>ユーザー</td>
                                <td>評価</td>
                                <td>コメント</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($reviews as $review)
                            <tr>
                                <td>{{ date('Y年m月d日', strtotime($review -> created_at))}}</td>
                                <td><a href = "{{ route('admin.products.show', [$review -> product_id]) }}">{{ $review -> product_id }}</a></td>
                                <td><a href = "{{ route('admin.customers.show', [$review -> customer_id]) }}">{{ $review -> customer_name }}({{ $review -> customer_id }})</a></td>
                                <td>{{ $review -> evaluat }}</td>
                                <td>{{ $review -> comment }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        @endif

    </section>
    <!-- /.content -->
@endsection
