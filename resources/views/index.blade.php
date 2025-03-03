<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ai Customer Assistant</title>


    {{-- Css --}}
    <link rel="stylesheet" href="{{ asset('style.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    {{-- Script --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    {{-- <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script> --}}

</head>

<body>
    {{-- <div class="chat">
        <div class="top">
            <p>Hi, how can I help you today?</p>
            <small>Online</small>
        </div>

        <div class="messages">
            @include('receive', ['message' => 'Hello, I need help with my order.'])
        </div> --}}

    {{-- <div class="bottom">
            <form action="">
                <input type="text" id="message" name="message" placeholder="Type your message...">
                <button class="btn btn-primary" type="submit"></button>
            </form>
        </div> --}}
    </div>


    <section>
        <div class="container py-5">

            <div class="row d-flex justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-4">

                    <div class="card" id="chat1" style="border-radius: 15px;">
                        <div class="card-header d-flex justify-content-between align-items-center p-3 bg-info text-white border-bottom-0"
                            style="border-top-left-radius: 15px; border-top-right-radius: 15px;">
                            <i class="fas fa-angle-left"></i>
                            <p class="mb-0 fw-bold">Live chat</p>
                            <i class="fas fa-times"></i>
                        </div>
                        <div class="card-body chat">

                            <div class="d-flex flex-row justify-content-start mb-4">
                                <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava1-bg.webp"
                                    alt="avatar 1" style="width: 45px; height: 100%;">
                                <div class="p-3 ms-3"
                                    style="border-radius: 15px; background-color: rgba(57, 192, 237,.2);">
                                    <p class="small mb-0">Hello and thank you for visiting MDBootstrap. Please click the
                                        video
                                        below.</p>
                                </div>
                            </div>

                            <div class="messages">
                                @include('receive', ['message' => 'Hello, I need help with my order.'])
                            </div>


                            <div data-mdb-input-init class="form-outline">
                                <div class="bottom">
                                    <form action="">
                                        <div class="input-group">
                                            <input class="form-control bg-body-tertiary" type="text" id="message"
                                                name="message" placeholder="Type your message...">
                                            <button class="btn btn-primary" type="submit">send</button>
                                        
                                    </form>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>

        </div>
    </section>




    <script>
        const pusher = new Pusher('{{ config('broadcasting.connections.pusher.key') }}', {
            cluster: 'ap1'
        });
        const channel = pusher.subscribe('chat-room');


        // receive message
        channel.bind('App\\Events\\MessageSent', function(data) {
            $.post("/receive", {
                _token: '{{ csrf_token() }}',
                message: data.message
            }).done(function(res) {
                $(".messages > .message").last().after(res);
                $(document).scrollTop($(document).height());
            })
        });

        // send message
        $("form").submit(function(e) {
            e.preventDefault();

            $.ajax({
                url: "/broadcast",
                method: "POST",
                headers: {
                    'X-Socket-ID': pusher.connection.socket_id
                },
                data: {
                    _token: '{{ csrf_token() }}',
                    message: $("form #message").val()
                }
            }).done(function(res) {
                $(".messages > .message").last().after(res);
                $("form #message").val('');
                $(document).scrollTop($(document).height());
            });

        });
    </script>
</body>

</html>
