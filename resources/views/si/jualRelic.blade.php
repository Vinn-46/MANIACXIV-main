@extends("si.layout.app")

@section("style")
    <style>
        :root {
            --c1: #733B22;
        }

        .c-tengah {
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }
    </style>
@endsection

@section("content")
    <div class="c-bg-white shadow-lg p-4 rounded-lg w-[86vw]">
        <div class="grid grid-cols-4">
            <!-- Sidebar Kiri -->
            <div class="col-span-1 bg-[#6e481a] p-4 border-[15px] border-[#ae8350] border-t-[#8b5f1e] border-b-[#8b5f1e]">
                <div class="space-y-4">
                    <div class="relative aspect-rectangle h-36 bg-[#be8f57] hover:shadow-[0_0_15px_6px_#faebbe] cursor-pointer flex items-center justify-center" onclick="changeRelic('red')">
                        <img src="{{ asset('asset2025/gameBesar/relic-red.png') }}" alt="item" class="max-h-full max-w-full">
                        @if(isset($playerInventory['red']->qty))
                            <span class="absolute bottom-1 right-1 text-xl font-['Lato'] font-semibold bg-[#f0e9cf] text-[#733b22]">x<span id="inventoryRelicMerah">{{ $playerInventory['red']->qty }}</span>&ensp;</span>
                        @else
                            <span class="absolute bottom-1 right-1 text-xl font-['Lato'] font-semibold bg-[#f0e9cf] text-[#733b22]">x<span id="inventoryRelicMerah">0</span>&ensp;</span>
                        @endif
                    </div>
                    <div class="relative aspect-rectangle h-36 bg-[#be8f57] hover:shadow-[0_0_15px_6px_#faebbe] cursor-pointer flex items-center justify-center" onclick="changeRelic('purple')">
                        <img src="{{ asset('asset2025/gameBesar/relic-purple.png') }}" alt="item" class="max-h-full max-w-full">
                        @if(isset($playerInventory['purple']->qty))
                            <span class="absolute bottom-1 right-1 text-xl font-['Lato'] font-semibold bg-[#f0e9cf] text-[#733b22]">x<span id="inventoryRelicUngu">{{ $playerInventory['purple']->qty }}</span>&ensp;</span>
                        @else
                            <span class="absolute bottom-1 right-1 text-xl font-['Lato'] font-semibold bg-[#f0e9cf] text-[#733b22]">x<span id="inventoryRelicUngu">0</span>&ensp;</span>
                        @endif
                    </div>
                    <div class="relative aspect-rectangle h-36 bg-[#be8f57] hover:shadow-[0_0_15px_6px_#faebbe] cursor-pointer flex items-center justify-center" onclick="changeRelic('blue')">
                        <img src="{{ asset('asset2025/gameBesar/relic-blue.png') }}" alt="item" class="max-h-full max-w-full">
                        @if(isset($playerInventory['blue']->qty))
                            <span class="absolute bottom-1 right-1 text-xl font-['Lato'] font-semibold bg-[#f0e9cf] text-[#733b22]">x<span id="inventoryRelicBiru">{{ $playerInventory['blue']->qty }}</span>&ensp;</span>
                        @else
                            <span class="absolute bottom-1 right-1 text-xl font-['Lato'] font-semibold bg-[#f0e9cf] text-[#733b22]">x<span id="inventoryRelicBiru">0</span>&ensp;</span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Sidebar Kanan -->
            <div class="col-span-3  p-6">
                <div class="relative flex justify-center items-center mb-4">
                    <h1 class="text-4xl font-['dalek'] text-[#733b22]" style="text-shadow: -3px 2px 0px #be8f57">Jual Relic</h1>
                    <span><button onclick="toggleInformasi()" class="absolute right-0 top-0 text-xl fa-solid fa-circle-info text-[#733b22]"></button></span>
                </div>
                <div class="flex justify-between mb-4 text-[#733b22]">
                    <div class="font-semibold font-['Lato'] uppercase">Team : {{ $currentTeam->name}}</div>
                    <div class="font-semibold font-['Lato']"><img src="{{ asset('asset2025/gameBesar/Tears.png') }}" class="inline"><span class="ml-2" id="jumUang">{{ $currentPlayer->tears }}</span></div>
                </div>

                <div class="relative">
                    <div class="top-2 bg-[#dba668] w-64 mx-auto relative flex justify-center text-center text-[#733b22] rounded-md">
                        <h2 class="text-2xl font-['Lato']"><span id="relicSellName">Jual</span></h2>
                    </div>
                </div>

                <div class="bg-[#e5d1b8] p-4 border-[20px] grid [grid-template-columns:0.9fr_1.1fr] grid-cols-2 gap-4 border-t-[#ae8350] border-b-[#ae8350] border-r-[#8b5f1e] border-l-[#8b5f1e]">
                    <div class="bg-[#be8f57] aspect-square h-72 rounded flex items-center justify-center">
                        <img src="" alt="" class="max-h-full max-w-full w-48" id="relicSellImage">
                    </div>
                    <div class="space-y-12">
                        <div class="mt-6 space-y-2 text-[#733b22]">
                            <h2 class="text-xl font-semibold font-['Lato']">HARGA ITEM</h2>
                            <p class="font-['Lato']"><img src="{{ asset('asset2025/gameBesar/Tears.png') }}" class="inline"> <input class="ml-1 mt-1 px-2 m-0 p-0" type="number" min="100" max="100000" id="nodeHargaRelic" placeholder="Ex. 100"></p>
                        </div>
                        <div class="flex items-center space-x-2 justify-between">
                            <button class="bg-[#6e481a] text-white px-4 h-10 font-extrabold font-['Lato'] rounded ml-2 text-3xl" onclick="subItem()">-</button>
                            <div class="secret" style="display:none;" id="secretRelicQty">0</div>
                            <span class="text-3xl text-[#733b22] font-['Lato'] font-bold" id="relicSellQty">0</span>
                            <button class="bg-[#6e481a] px-4 h-10 text-white font-extrabold font-['Lato'] rounded mr-2 text-3xl" onclick="addItem()">+</button>
                        </div>
                        <div class="flex justify-between">
                            <button class="bg-[#6e481a] text-md w-full text-white px-14 py-1 rounded-full font-['Lato']" onclick="sellRelic()">JUAL</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex justify-center mt-4">
                <a href="{{ route('si.index', ['player' => $currentPlayer->id ?? null]) }}" class="w-1/2">
                    <button class="bg-[#6e481a] text-white px-8 py-2 rounded-full font-['Lato'] font-bold text-lg ">Beli</button>
                </a>
            </div>
        </div>
    </div>

    <div id="informasi" class="hidden absolute w-[75vw] rounded-[1vw] bg-[#6e481a] p-4 border-[15px] border-[#ae8350] border-t-[#8b5f1e] border-b-[#8b5f1e]">
        <div class="bg-[#FBFBF3] w-[70vw] rounded-[1vw]">
            <h1 class="text-[4vw] font-['dalek'] text-[#733b22] text-center" style="text-shadow: -3px 2px 0px #be8f57">Informasi</h1>
            <div onclick="closeInformasi()" class="fa-solid fa-circle-xmark color text-[#FF0000] text-[2vw] absolute top-[2vw] right-[3%]"></div>
        </div>
        <div class="bg-[#FBFBF3] w-[70vw] rounded-[1vw] p-4 font-['Lato'] mt-[2vw]">
            <!-- SHOP Table -->
            <table class="table-auto border border-black w-full text-sm text-center">
                <thead>
                    <tr class="bg-[#6E481A] text-white">
                        <th colspan="5" class="border border-black px-2 py-1">SHOP</th>
                    </tr>
                    <tr class="bg-[#8B5F1E] text-white">
                        <th rowspan="2" class="border border-black px-2 py-1">Sesi</th>
                        <th rowspan="2" class="border border-black px-2 py-1">Harga Jual</th>
                        <th colspan="3" class="border border-black px-2 py-1">Harga Beli (harga jual + persentase)</th>
                    </tr>
                    <tr class="bg-[#8B5F1E] text-white">
                        <th class="border border-black px-2 py-1">Relic Biru</th>
                        <th class="border border-black px-2 py-1">Relic Merah</th>
                        <th class="border border-black px-2 py-1">Relic Ungu</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="border border-black px-2 py-1">Sesi 1</td>
                        <td rowspan="4" class="border border-black px-2 py-1 align-middle">Sesuai Inputan Peserta</td>
                        <td class="border border-black px-2 py-1" colspan="3">3%</td>
                    </tr>
                    <tr>
                        <td class="border border-black px-2 py-1">Sesi 2</td>
                        <td class="border border-black px-2 py-1" colspan="3">5%</td>
                    </tr>
                    <tr>
                        <td class="border border-black px-2 py-1">Sesi 3</td>
                        <td class="border border-black px-2 py-1" colspan="3">8%</td>
                    </tr>
                </tbody>
            </table>

            <!-- Spacer -->
            <div class="h-6"></div>

            <!-- Withdraw Table -->
            <table class="table-auto border border-black w-full text-sm text-center">
                <thead>
                    <tr class="bg-[#8B5F1E] text-white">
                        <th rowspan="2" class="border border-black px-2 py-1">Sesi</th>
                        <th rowspan="2" class="border border-black px-2 py-1">Harga Awal</th>
                        <th colspan="3" class="border border-black px-2 py-1">Withdraw<br>(harga beli + persentase)</th>
                    </tr>
                    <tr class="bg-[#8B5F1E] text-white">
                        <th class="border border-black px-2 py-1">Relic Biru</th>
                        <th class="border border-black px-2 py-1">Relic Merah</th>
                        <th class="border border-black px-2 py-1">Relic Ungu</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="border border-black px-2 py-1">Sesi 1</td>
                        <td rowspan="4" class="border border-black px-2 py-1 align-middle">Sesuai Inputan Peserta</td>
                        <td class="border border-black px-2 py-1" colspan="3">2%</td>
                    </tr>
                    <tr>
                        <td class="border border-black px-2 py-1">Sesi 2</td>
                        <td class="border border-black px-2 py-1" colspan="3">3%</td>
                    </tr>
                    <tr>
                        <td class="border border-black px-2 py-1">Sesi 3</td>
                        <td class="border border-black px-2 py-1" colspan="3">5%</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    </div>
@endsection

@section("script")
    <script>
        const redRelicElement = $("#inventoryRelicMerah");
        const blueRelicElement = $("#inventoryRelicBiru");
        const purpleRelicElement = $("#inventoryRelicUngu");
        const secretRelicQty = $("#secretRelicQty");
        const relicSellQty = $("#relicSellQty");
        const relicSellImage = $("#relicSellImage");
        const relicSellName = $("#relicSellName");
        const assetBaseUrl = "{{ asset('') }}";
        const playerInventory = @json($playerInventory);
        const nodeHargaRelic = $("#nodeHargaRelic");
        let chosenRelic = null;

        const sellRelic = () => {
            if (chosenRelic == null) {
                Swal.fire({
                    title: 'Pilih relic yang ada!',
                    text: "Silakan pilih relic yang ingin dijual.",
                    icon: 'info',
                });
                return;
            } else if (secretRelicQty.text() == "0") {
                Swal.fire({
                    title: 'Stok Relic Kurang!',
                    text: "Relic yang ingin dijual berjumlah 0.",
                    icon: 'info',
                });
                return;
            }
            let playerId = @json($currentPlayer).id;
            let relicId = chosenRelic.relic_id;
            let qty = parseInt(relicSellQty.text());
            let tears = +nodeHargaRelic.val();

            // console.log(`[sellRelic] Player ID ${playerId}, Relic ID ${relicId}, Quantity ${qty}, Tears ${tears}`);

            $.ajax({
                type: "POST",
                url: "{{ route('si.sellRelic', ['player' => ':player_id']) }}"
                    .replace(':player_id', playerId),
                data: {
                    '_token': "{{ csrf_token() }}",
                    'player': playerId,
                    'relic': relicId,
                    'qty': qty,
                    'tears': tears
                },
                success: function (response) {
                    if (response.isError) {
                        Swal.fire({
                            title: 'Gagal!',
                            text: response.msg,
                            icon: 'info',
                        });
                    } else {
                        Swal.fire({
                            title: 'Berhasil!',
                            text: response.msg,
                            icon: 'success',
                        });

                        // PLAYER RELICS
                        console.log("[sellRelic] Response:", response.playerInventory);
                        $('#inventoryRelicMerah').text(response.playerInventory.red.qty);
                        $('#inventoryRelicUngu').text(response.playerInventory.purple.qty);
                        $('#inventoryRelicBiru').text(response.playerInventory.blue.qty);
                    }
                }
            });
        }

        const changeRelic = clickedRelicColor => {
            chosenRelic = playerInventory[clickedRelicColor];
            secretRelicQty.text(chosenRelic.qty);

            let newImagePath = `${assetBaseUrl}asset2025/gameBesar/relic-${clickedRelicColor}.png`;
            $("#relicSellImage").attr("src", newImagePath);
            relicSellQty.text(1);
            relicSellName.text(chosenRelic.name);
        }

        const addItem = () => {
            if (secretRelicQty.text() == "0") {
                Swal.fire({
                    title: 'Pilih relic yang ada!',
                    text: "Silakan pilih relic yang ingin dijual.",
                    icon: 'info',
                });
                return;
            }

            let currentQty = parseInt(relicSellQty.text()) + 1;
            if (currentQty <= secretRelicQty.text()) {
                relicSellQty.text(currentQty);
            }
        }

        const subItem = () => {
            // console.log("[subItem] Decreasing item...");
            if (secretRelicQty.text() == "0") {
                Swal.fire({
                    title: 'Pilih relic yang ada!',
                    text: "Silakan pilih relic yang ingin dijual.",
                    icon: 'info',
                });
                return;
            }

            let currentQty = parseInt(relicSellQty.text()) - 1;
            if (currentQty > 0) {
                relicSellQty.text(currentQty);
            }
        }
    </script>
    <script>
        function toggleInformasi() {
            console.log("piupiu");
            const informasi = document.getElementById("informasi");
            informasi.setAttribute("class", "absolute w-[75vw] rounded-[1vw] bg-[#6e481a] p-4 border-[15px] border-[#ae8350] border-t-[#8b5f1e] border-b-[#8b5f1e]");
        }

        const closeInformasi = () => {
            const informasi = document.getElementById("informasi");
            informasi.setAttribute("class", "hidden absolute w-[75vw] rounded-[1vw] bg-[#6e481a] p-4 border-[15px] border-[#ae8350] border-t-[#8b5f1e] border-b-[#8b5f1e]")
        }
    </script>
    <script type="module">
        let playerId = @json($currentPlayer).id;
        window.Echo.channel('update-tears-semi-private').listen('UpdateTearsSemiPrivate', event => {
            console.log("[UpdateTearsSemiPrivate] Event:", event);
            console.log("[UpdateTearsSemiPrivate] Player ID:", event.receiverId + " | " + playerId);
            if (event.receiverId != playerId) {
                return;
            }

            $("#jumUang").text(event.tears);
        });
    </script>
@endsection