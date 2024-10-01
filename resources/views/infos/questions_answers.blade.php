@include ('/layouts/header')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

<div class="container-fluid">
        <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4"><span class="bg-secondary pr-3">Вопросы и Ответы</span></h2>
        <div class="row px-xl-5" >
            <div class="col-lg-7 mb-5" style="margin: auto;">
                <div class="contact-form bg-light p-30">
                    <div class="accordion accordion-flush" id="accordionFlushExample">
                        @foreach($questions_answers as $item)
                            <div class="accordion-item">
                            <h2 class="accordion-header" id="flush-{{$item->id}}">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-{{$item->id}}{{$item->id}}" aria-expanded="false" aria-controls="flush-{{$item->id}}{{$item->id}}">
                                {{$item->questions}}
                                </button>
                            </h2>
                            <div id="flush-{{$item->id}}{{$item->id}}" class="accordion-collapse collapse" aria-labelledby="flush-{{$item->id}}" data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body">{{$item->answers}}</div>
                            </div>
                            </div>
                        @endforeach
                      </div>
                </div>
            </div>
        </div>
    </div>


@include ('/layouts/footer')