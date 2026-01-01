@extends('layouts.site')

@section('title', $product->translate('title') ?? 'Ürün Detayı')
@section('meta_description', Str::limit(strip_tags($product->translate('content')), 160))

@section('content')
<section class="wrapper !bg-[#ffffff]">
    <div class="container py-14 xl:py-16 lg:py-16 md:py-16">
        <div class="flex flex-wrap mx-[-15px]">
            <div class="xl:w-10/12 lg:w-10/12 w-full flex-[0_0_auto] px-[15px] max-w-full !mx-auto">
                <div class="post-header !mb-[.9rem]">
                    <div class="post-category text-line text-[#aab0bc] !mb-3">
                        <span class="hover:!text-[#3f78e0]">{{ $product->type == 'product' ? 'Ürün' : 'Hizmet' }}</span>
                        @if($product->category)
                             / <span class="hover:!text-[#3f78e0]">{{ $product->category->translate('title') }}</span>
                        @endif
                    </div>
                    <!-- /.post-category -->
                    <h1 class="!text-[2.5rem] !leading-[1.2] !mb-4">{{ $product->translate('title') }}</h1>
                </div>
                <!-- /.post-header -->
                
                @if($product->hero_image)
                <figure class="!mb-[2rem] !rounded-[.4rem]">
                    <img class="!rounded-[.4rem] w-full" src="{{ Storage::url($product->hero_image) }}" alt="{{ $product->translate('title') }}">
                </figure>
                @endif
                
                <div class="post-content">
                    {!! $product->translate('content') !!}
                </div>
                <!-- /.post-content -->
            </div>
            <!-- /column -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container -->
</section>
@endsection

