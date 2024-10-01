@include ('/layouts/header')

<div class="container-fluid">
        <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4"><span class="bg-secondary pr-3">{{$infoblock->title}}</span></h2>
        <div class="row px-xl-5">
            <div class="col-lg-7 mb-5">
                <div class="contact-form bg-light p-30">
                    <p><b>{{$infoblock->subtitle}}</b></p>
                    <p>{{$infoblock->content}}</p>
                </div>
            </div>
            <div class="col-lg-5 mb-5">
                <div class="bg-light p-30 mb-30">
                    <p style="text-align: center;">
                        <img src="/images/info/{{$infoblock->photo}}" alt="" style="max-width: 600px;">
                    </p>
                </div>
                <div class="bg-light p-30 mb-3">
                    <p><b>Также можете прочитать:</b></p>
                    <ul>
                        @foreach ($all as $item)
                            <li><a style='color:black;' href="/getInfoblock/{{$item->id}}">{{$item->title}}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
</div>

@include ('/layouts/footer')