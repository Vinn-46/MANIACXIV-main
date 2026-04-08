@extends("si.layout.app")

@section("style")
    <style>
        :root{
            --c1: #733B22; 
        }
        .secret{
            display: none;
        }
        .c-pointer{
            cursor: pointer;
        }
    </style>
@endsection

@section("content")
    <div class="c-bg-white shadow-lg p-4 rounded-lg grid grid-cols-3 max-w-[86vw]">
        <!-- Sidebar kiri -->
        <div class="col-span-1 max-h-[70vh] h-screen bg-[#6e481a] pl-6 p-4 border-[20px] border-[#ae8350] border-t-[#8b5f1e] border-b-[#8b5f1e] overflow-y-auto">
            <div class="grid grid-cols-2 gap-3" id="market-items-container">
            </div>
        </div>

        <!-- Konten utama -->
        <div class="col-span-2 p-6" id="nodeItemMarketTerpilih" secret="">
            <div class="flex justify-between items-start">
                <div class="space-y-4 font-bold font-['Lato'] text-xl">
                    <div class="relative flex justify-center items-center mb-4">
                        <h1 class="text-4xl font-['dalek'] text-[#733b22]" style="text-shadow: -3px 2px 0px #be8f57">Beli Relic</h1>
                    </div>
                    <div class="flex items-center">
                        <div>
                            Nama Tim:
                        </div>
                        <select id="pID" class="js-example-basic-single w-[20vw] ml-2 py-1" name="state">
                            <option selected disabled value="">Select Player</option>
                            @foreach ($players as $p)
                                <option value="{{ $p->id }}" {{ request('player') == $p->id ? 'selected' : '' }}>
                                    {{ $p->team_name }}
                                </option>
                            @endforeach 
                        </select>
                    </div>
                    <div>
                        <img src="{{ asset('asset2025/gameBesar/Tears.png') }}" class="inline h-6"> <span id="tearsPlayer">0</span> Tears
                    </div>
                    <div class="font-bold font-['Lato'] text-xl flex items-center space-x-4">
                        <div>
                            <div>MISI</div>
                            <div class="flex">
                                @if(isset($relicMisis))
                                    @foreach ($relicMisis as $relicMisi)
                                        <div class="pr-2 mr-3 relative">
                                            @if ($relicMisi->relic_id == 1)
                                                <img src="{{ asset('asset2025/gameBesar/relic-red.png') }}" class="h-16">
                                            @elseif ($relicMisi->relic_id == 2)
                                                <img src="{{ asset('asset2025/gameBesar/relic-purple.png') }}" class="h-16">
                                            @else
                                                <img src="{{ asset('asset2025/gameBesar/relic-blue.png') }}" class="h-16">
                                            @endif    
                                            <div class="rounded-full bg-[#6e481a] absolute bottom-0 right-0 text-center">
                                                <p class="text-[12px] font-bold text-[#e5d1b8] px-2">{{ $relicMisi->qty }}</p>                            
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>

                        {{-- Container to hold redeem button, initially hidden --}}
                        <div id="redeemMissionContainer" style="display:none;" class="my-auto">
                            <button 
                                type="button"
                                id="redeemMissionButton"
                                onclick="redeemMission()"
                                class="bg-green-600 hover:bg-green-500 text-white font-semibold py-2 px-4 rounded transition-all active:scale-95"
                            >
                                Redeem Mission
                            </button>
                        </div>
                    </div>
                </div>
                <div class="relative top-6 right-10 z-10 overflow-hidden h-56 w-auto">
                    <img src="{{ asset('asset2025/gameBesar/Athena.png') }}" class="object-contain h-[40vh]">
                </div>
            </div>

            <!-- Display Item -->
            <div class=" top-2 bg-[#dba668] w-64 mx-auto relative flex justify-center text-center text-[#733b22] rounded-md">
                <h2 class="text-2xl font-['Lato']"><span id="dNamaRelic">Beli</span></h2>
            </div>
            
            <!-- Display Item -->
            <div class="bg-[#e5d1b8] p-4 border-[20px] border-t-[#ae8350] border-b-[#ae8350] border-r-[#8b5f1e] border-l-[#8b5f1e]">
                <div class="flex justify-center">                 
                    <div class="w-[27%]">
                        <div class="bg-[#be8f57] relative aspect-square h-48 rounded flex items-center justify-center w-full">
                            <img src="" alt="" id="dImgRelic" class="overflow-hidden object-contain">
                            <div class="rounded-full bg-[#6e481a] absolute bottom-1 right-1 text-center">
                                <p class="text-[9px] font-bold text-[#e5d1b8] px-3 py-2" id="dJumRelic">0</p>                    
                            </div>
                        </div>
                    </div>
                    <div class="w-[73%] ml-6 flex flex-col justify-between">
                        <div class="text-[#733b22] mt-[10%]">  
                            <h2 class="text-xl font-semibold font-['Lato']">HARGA ITEM</h2>
                            <p class="font-['Lato'] text-xl">
                                <img src="{{ asset('asset2025/gameBesar/Tears.png') }}" class="inline h-6">     
                                <span id="dHargaRelic">0</span> Tears
                            </p>
                        </div>
                        <div class="flex items-center space-x-2 justify-between mx-[10%] mt-4">
                            <button class="bg-[#6e481a] text-white px-4 h-10 font-extrabold font-['Lato'] rounded text-3xl" onclick="subItem()">-</button>
                            <span class="text-3xl text-[#733b22] font-['Lato'] font-bold" id="jumItem">0</span>
                            <button class="bg-[#6e481a] px-4 h-10 text-white font-extrabold font-['Lato'] rounded text-3xl" onclick="addItem()">+</button>
                        </div>
                        <div class="flex justify-center mt-7">
                            <button id="buyRelicButton" class="bg-[#6e481a] text-white px-8 py-2 rounded-full font-['Lato'] font-bold text-lg w-3/4" onclick="buyRelic()">Beli Relic</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-5 flex justify-center">
            <button onclick="sellRelic()" class="bg-[#6e481a] text-white w-[50%] py-2 rounded-full font-['Lato'] font-bold text-lg ">
                <a class="w-1/2">Jual Relic</a>
            </button>
        </div>
    </div>
@endsection

@section("script")
<script>
    const missionId = {{ $sessionMission->id ?? 'null' }};
</script>
<script>
    $(document).ready(function() {
        let selectedPlayerId = $('#pID').val();
        if (selectedPlayerId) {
            // For AJAX
            $('#pID').trigger('change');

            // For URL
            const url = new URL(window.location.href);
            url.searchParams.delete('player');
            window.history.replaceState({}, '', url);
        }
    });

    const nodeDNamaRelic = $("#dNamaRelic");
    const nodeDImgRelic = $("#dImgRelic");
    const nodeDJumRelic = $("#dJumRelic");
    const nodeDHargaRelic = $("#dHargaRelic");
    const nodeJumlItem = $("#jumItem");
    const assetBaseUrl = "{{ asset('') }}";
    const nodeBeliRelic = $("#nodeBeliRelic");
    const nodeItemMarketTerpilih = $("#nodeItemMarketTerpilih");

    const BuyMultiplierEnum = {
        1: 0.03,
        2: 0.05,
        3: 0.08
    };

    const WithdrawMultiplierEnum = {
        1: 0.02,
        2: 0.03,
        3: 0.05
    };

    let justBoughtMarketId = null;

    // Ganti-ganti player
    $('#pID').change(function(e) {
        let playerId = $(this).val();

        if (!playerId) {
            Swal.fire({
                title: 'Player belum dipilih!',
                text: "Silakan pilih player terlebih dahulu.",
                icon: 'info',
            });
            // Hide redeem button if no player selected
            $('#redeemMissionContainer').hide();
            return;
        }

        $.ajax({
            url: "{{ route('si.player.detail', ['player' => ':player_id']) }}".replace(':player_id', playerId),
            method: 'POST',    
            dataType: 'json',  
            data: {          
                "_token": "{{ csrf_token() }}",    
                'player': playerId              
            },
            success: function(response) {                
                console.log("[pID] Response:", response);  
                if (response.isError) {                  
                    Swal.fire({                        
                        title: "Game Besar belum dimulai!",
                        text: response.msg,
                        icon: 'info',
                    });
                    $('#pID').val('');
                    // Hide redeem button on error
                    $('#redeemMissionContainer').hide();
                    return;
                }

                console.log("[ChangePlayer] Ganti Pemain Berhasil");

                let isRedeemed = response.isRedeemed;

                const redeemBtn = $('#redeemMissionButton');
                if (isRedeemed) {
                    redeemBtn.prop('disabled', true).removeClass('bg-green-600 hover:bg-green-500').addClass('bg-gray-400 cursor-not-allowed');
                    redeemBtn.text('Misi Sudah Ditukar');
                } else {
                    redeemBtn.prop('disabled', false).removeClass('bg-gray-400 cursor-not-allowed').addClass('bg-green-600 hover:bg-green-500');
                    redeemBtn.text('Redeem Mission');
                }
                // Show redeem button
                let formAction = "{{ route('si.redeemMission', ['player' => ':player_id']) }}".replace(':player_id', playerId);
                $('#redeemMissionForm').attr('action', formAction);
                $('#redeemMissionContainer').show();
            },
            error: function(xhr) {
                console.log(xhr);
                // Hide redeem button on error
                $('#redeemMissionContainer').hide();
            }
        });
    });

    // Pindah ke halaman jual Relic
    const sellRelic = () => {
        let playerId = $("#pID").val();

        if (!playerId) {
            Swal.fire({
                title: 'Player belum dipilih!',
                text: "Silakan pilih player terlebih dahulu.",
                icon: 'info',
            });
            return;
        }
        
        let newUrl = "{{ route('si.jualRelic', ['player' => ':player_id'])}}".replace(':player_id', playerId);
        
        window.location.href = newUrl;
    }

    // Pilih relic untuk di beli
    const changeRelic = clickedItemId => {
        let tmp = clickedItemId.split("-");
        idMarketTerpilih = tmp[1];
        nodeItemMarketTerpilih.attr("secret", idMarketTerpilih);
        let playerId = $("#pID").val();

        if (!playerId) {
            Swal.fire({
                title: 'Player belum dipilih!',
                text: "Silakan pilih player terlebih dahulu.",
                icon: 'info',
            });
            return;
        }

        console.log("[changeRelic] Clicked item ID:", clickedItemId);
        
        // SELECTED OFFER BORDER, SHADOW, WHATEVER
        $('.c-pointer').removeAttr('style');

        let marketOfferUI = $(`#${clickedItemId}`);
        marketOfferUI.css({
            'background-color': '#bf8641',
            'box-shadow': '0 0 15px 6px #faebbe',
            'border': '4px solid #facc15'
        });

        // GET SECRET DATA
        let idNew = "#secret" + clickedItemId;
        let secretData = $(idNew).text().split("-");
        console.log(idNew, secretData);
        // 0: market id
        // 1: qty
        // 2: tears
        // 3: player_id
        // 4: relic_id
        // 5: relic name
        let relicImageSelect = null;
        if (secretData[4] == 1) {
            relicImageSelect = "red";
        }

        if (secretData[4] == 2) {
            relicImageSelect = "purple";
        }

        if (secretData[4] == 3) {
            relicImageSelect = "blue";
        }
        if (secretData.length >= 6) {
            let newImagePath = `${assetBaseUrl}asset2025/gameBesar/relic-${relicImageSelect}.png`;
            nodeDImgRelic.attr("src", newImagePath); 
            nodeDNamaRelic.text(secretData[5]);
            nodeDJumRelic.text(secretData[1]);
            nodeDHargaRelic.text(secretData[2]);
        } else {
            console.error("Could not parse secret data for selector:", secretDataSelector);
        }

        console.log("[changeRelic] Set secret to Id:", idMarketTerpilih);

        // SET BUYING QTY TO 1
        nodeJumlItem.text(1);
        console.log("[ChangeRelic] Ganti Relic Berhasil");

        updateTotalPrice();
    }

    // Menambah jumlah relic yang mau dibeli
    const addItem = () => {
        if (nodeJumlItem.text() == "0") {
            Swal.fire({
                title: 'Tawaran belum dipilih!',
                text: "Silakan pilih relic terlebih dahulu.",
                icon: 'info',
            });
            return;
        }

        let currentQty = parseInt(nodeJumlItem.text()) + 1;

        if (currentQty <= nodeDJumRelic.text()) {
            nodeJumlItem.text(currentQty);
            updateTotalPrice();
        }
    }

    // Mengurangi jumlah relic yang mau dibeli
    const subItem = () => {
        if (nodeJumlItem.text() == "0") {
            Swal.fire({
                title: 'Tawaran belum dipilih!',
                text: "Silakan pilih relic terlebih dahulu.",
                icon: 'info',
            });
            return;
        }

        let currentQty = parseInt(nodeJumlItem.text()) - 1;

        if (currentQty > 0) {
            nodeJumlItem.text(currentQty);
            updateTotalPrice();
        }
    }

    // Membeli relic
    const buyRelic = () => {
        let playerId = $("#pID").val();
        const buyButton = $("#buyRelicButton"); // Get the button element
        justBoughtMarketId = nodeItemMarketTerpilih.attr("secret");

        // Disable the button immediately to prevent double clicks
        buyButton.prop("disabled", true).addClass("opacity-50 cursor-not-allowed");

        $.ajax({
            url: "{{ route('si.buyRelic', ['player' => ':player_id']) }}".replace(':player_id', playerId),
            method: 'POST',
            dataType: 'json',
            data: {
                "_token": "{{ csrf_token() }}",
                'player': playerId,
                "market": justBoughtMarketId,
                "qty": $("#jumItem").text()
            },
            success: function(response) {
                console.log(response);

                // Re-enable button
                buyButton.prop("disabled", false).removeClass("opacity-50 cursor-not-allowed");

                if (response.isError) {
                    Swal.fire({
                        title: response.title,
                        text: response.msg,
                        icon: 'info',
                    });
                    justBoughtMarketId = null;
                    return;
                }

                Swal.fire({
                    title: "Pembelian Berhasil",
                    text: response.msg,
                    icon: 'success',
                });
            },
            error: function(xhr) {
                console.log(xhr);

                // Re-enable button on error too
                buyButton.prop("disabled", false).removeClass("opacity-50 cursor-not-allowed");

                Swal.fire({
                    title: xhr.title || 'Terjadi kesalahan!',
                    text: xhr.msg || 'Silakan coba lagi atau hubungi panitia.',
                    icon: 'error',
                });

                justBoughtMarketId = null;
            }
        });
    };

    const redeemMission = () => {
        const playerId = $('#pID').val();

        if (!playerId) {
            Swal.fire({
                title: 'Player belum dipilih!',
                text: "Silakan pilih player terlebih dahulu.",
                icon: 'info',
            });
            return;
        }

        $.ajax({
            url: "{{ route('si.redeemMission', ['player' => ':player_id']) }}".replace(':player_id', playerId),
            method: 'POST',
            data: {
                _token: "{{ csrf_token() }}"
            },
            success: function(response) {
                if (response.isError) {
                    Swal.fire({
                        title: 'Gagal!',
                        text: response.msg,
                        icon: 'error',
                    });
                } else {
                    Swal.fire({
                        title: 'Misi Berhasil Diselesaikan!',
                        text: response.msg,
                        icon: 'success',
                    });

                    const redeemBtn = $('#redeemMissionButton');
                    redeemBtn.prop('disabled', true)
                        .removeClass('bg-green-600 hover:bg-green-500')
                        .addClass('bg-gray-400 cursor-not-allowed');
                    redeemBtn.text('Misi Sudah Ditukar');
                }
            },
            error: function(xhr) {
                Swal.fire({
                    title: 'Terjadi kesalahan!',
                    text: 'Silakan coba lagi atau hubungi panitia.',
                    icon: 'error',
                });
            }
        });
    };

    const updateTotalPrice = () => {
        const marketId = nodeItemMarketTerpilih.attr("secret");
        const secretText = $("#secretoffer-" + marketId).text();
        console.log("[UpdateTotalPrice] secretText:", secretText);

        const secretParts = secretText.split("-");
        if (secretParts.length < 4) {
            console.warn("Invalid secret data format for marketId:", marketId);
            return;
        }
        console.log("[UpdateTotalPrice] secretParts:", secretParts);

        // 0: ${marketItem.id}-
        // 1: ${marketItem.qty}-
        // 2: ${marketItem.tears}-
        // 3: ${marketItem.player_id}-
        // 4: ${marketItem.relic_id}-
        // 5: ${marketItem.relic_name}

        const qty = parseInt(nodeJumlItem.text());
        console.log("[UpdateTotalPrice] qty:", qty);

        const basePrice = parseInt(secretParts[2]);
        console.log("[UpdateTotalPrice] basePrice:", basePrice);

        const sellerId = parseInt(secretParts[3]);
        console.log("[UpdateTotalPrice] sellerId:", sellerId);

        const buyerId = parseInt($("#pID").val());
        console.log("[UpdateTotalPrice] buyerId:", buyerId);

        // Declared a top
        console.log("[UpdateTotalPrice] missionId:", missionId);

        if (!qty || !basePrice || !missionId || isNaN(sellerId) || isNaN(buyerId)) {
            console.warn("Invalid data for update price");
            return;
        }

        let total = basePrice * qty;

        if (buyerId === sellerId) {
            const multiplier = WithdrawMultiplierEnum[missionId] || 0;
            total += total * multiplier;
        } else {
            const multiplier = BuyMultiplierEnum[missionId] || 0;
            total += total * multiplier;
        }

        console.log("[UpdateTotalPrice] BasePrice:", basePrice, "Qty:", qty, "Total:", total);
        nodeDHargaRelic.text((Math.round(total * 100) / 100).toFixed(2)); //100 = round 2 decimal places, adjust as needed
    };
</script>
@vite('resources/js/app.js')

<script type="module">
    window.Echo.channel('update-market').listen('UpdateMarket', event => {   
            // MARKET OFFERS
            const marketContainer = $('#market-items-container');
            let playerId = $("#pID").val();
            marketContainer.empty();

            if ($("#nodeItemMarketTerpilih").attr("secret")) {
                const selectedMarketId = $("#nodeItemMarketTerpilih").attr("secret");

                const nodeDNamaRelic = $("#dNamaRelic");
                const nodeDImgRelic = $("#dImgRelic");
                const nodeDJumRelic = $("#dJumRelic");
                const nodeDHargaRelic = $("#dHargaRelic");
                const nodeJumlItem = $("#jumItem");
                const nodeItemMarketTerpilih = $("#nodeItemMarketTerpilih");

                const selectedStillExists = event.markets.some(marketItem => marketItem.id.toString() === selectedMarketId.toString());

                if (!selectedStillExists) {
                    // Don't show alert if this client just bought it
                    if (selectedMarketId !== justBoughtMarketId) {
                        Swal.fire({
                            title: 'Item Sudah Terbeli',
                            text: 'Item yang Anda pilih sudah dibeli oleh orang lain.',
                            icon: 'warning',
                        });
                    }

                    // Always reset UI
                    $("#nodeItemMarketTerpilih").attr("secret", null);
                    nodeDNamaRelic.text("");
                    nodeDImgRelic.attr("src", "");
                    nodeDHargaRelic.text("0");
                    nodeJumlItem.text("0");
                    nodeDJumRelic.text("0");

                    justBoughtMarketId = null; // clear flag
                }
            }

            event.markets.forEach(marketItem => {
                console.log("[UpdateMarket] Market item:", marketItem);

                let relicImagePath = '';
                if (marketItem.relic_id == 1) {
                    relicImagePath = `${assetBaseUrl}asset2025/gameBesar/relic-red.png`;
                } else if (marketItem.relic_id == 2) {
                    relicImagePath = `${assetBaseUrl}asset2025/gameBesar/relic-purple.png`;
                } else if (marketItem.relic_id == 3) {
                    relicImagePath = `${assetBaseUrl}asset2025/gameBesar/relic-blue.png`;
                } else {
                    console.error("[UpdateMarket] Unknown relic_id:", marketItem.relic_id);
                    return;
                }

                const relicOfferHtml = `
                    <div class="relative w-36 h-40 bg-[#be8f57] hover:shadow-[0_0_15px_6px_#faebbe] cursor-pointer flex items-center justify-center c-pointer
                    ${marketItem.player_id == playerId ? 'border-2 border-green-500' : ''}" 
                    id="offer-${marketItem.id}" 
                    onclick="changeRelic(this.id)">
                        <div class="secret" style="display:none;" id="secretoffer-${marketItem.id}">${marketItem.id}-${marketItem.qty}-${marketItem.tears}-${marketItem.player_id}-${marketItem.relic_id}-${marketItem.relic_name}</div>
                        <img src="${relicImagePath}" class="h-16 pb-2">
                        <div class="rounded-full bg-[#6e481a] absolute bottom-0 left-0 text-center">
                            <p class="text-[9px] font-bold text-[#e5d1b8] p-2 text-lg"><img src="{{ asset('asset2025/gameBesar/Tears.png') }}" class="inline h-3 pr-0.5"><span>${marketItem.tears}</span></p>
                        </div>
                        <div class="rounded-full bg-[#6e481a] absolute bottom-0 right-0 text-center">
                            <p class="text-[9px] font-bold text-[#e5d1b8] p-2 text-lg"><span id="jum-${marketItem.id}">${marketItem.qty}</span></p>
                        </div>
                    </div>
                `;

                marketContainer.append(relicOfferHtml);
                if (nodeItemMarketTerpilih.attr("secret") == marketItem.id){
                    nodeDJumRelic.text(marketItem.qty)
                }
            });
        }
    );
    
    window.Echo.channel('update-tears-semi-private').listen('UpdateTearsSemiPrivate', event => { 
        console.log("[UpdateTearsSemiPrivate] Event:", event);
        console.log("[UpdateTearsSemiPrivate] Player ID:", event.receiverId + " | " + $("#pID").val());
        if (event.receiverId != $("#pID").val()) {
            return;
        } 

        $("#tearsPlayer").text(event.tears);
    });
</script>
@endsection