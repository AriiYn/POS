<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TRANSAKSI</title>
    <link rel="stylesheet" href="{{ asset('transaksi.css') }}">
</head>

<body>
    <div class="container">
        <div class="navbar">
            <div class="nav-items">
                <a href="{{ route('produk.index') }}" class="nav-item">Produk</a>
                <a href="{{ route('detail.index') }}" class="nav-item">Detail Transaksi</a>
            </div>
        </div>

        <div class="main">
            <div class="main-left">
                <!-- Form Search & Filter -->
                <form action="{{ route('produk.search') }}" method="GET">
                    <div class="toolbar">
                        <div class="search-input">
                            <input type="text" id="searchInput" placeholder="Search here...." oninput="searchMenu()">
                        </div>
                        <div class="filter-icon"></div>
                        <div class="filter-icon"></div>
                        <div class="filter-icon">||</div>
                        <div class="filter-icon"></div>
                        <div class="filter-action">
                            <div class="drop-menu">
                                <!-- "category" = name field untuk penangkapan di Controller -->
                                <select name="category" class="theme-orange">
                                    <option value="all"
                                        {{ (request('category') === 'all' || !request('category')) ? 'selected' : '' }}>
                                        All
                                    </option>
                                    <option value="Minuman"
                                        {{ request('category') === 'Minuman' ? 'selected' : '' }}>
                                        Minuman
                                    </option>
                                    <option value="Makanan"
                                        {{ request('category') === 'Makanan' ? 'selected' : '' }}>
                                        Makanan
                                    </option>
                                </select>
                            </div>
                        </div>
                        <!-- Tombol submit -->
                        <button type="submit" class="pay-button">Search</button>
                        <button type="button" class="cancel-button" onclick="window.location.href='{{ route('transaksi.index') }}'">Reset</button>
                    </div>
                </form>

                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if(session('success'))
                    <div class="alert alert-error">{{ session('error') }}</div>
                @endif

                <!-- List Produk -->
                <div class="wrapper-card">
                    @foreach ($menu as $product)
                        <div class="card-container"
                            id="card{{ $product->id }}"
                            data-category="{{ $product->kategori }}"
                            data-type="{{ $product->total_terjual >= 10 ? 'Favorit' : 'Underrated' }}"
                            onclick="addToOrder('{{ $product->id }}', '{{ $product->nama_produk }}', '{{ $product->total_harga }}', '{{ $product->stok }}')">

                            <div class="card-info">
                                <div class="card-title">{{ $product->nama_produk }}</div>
                                <div class="card-category">{{ $product->kategori }}</div>
                            </div>
                            <div class="card-price">
                                <div class="card-dist" style="color: red;">
                                    Rp {{ number_format($product->harga, 0, ',', '.') }}
                                </div>
                            </div>
                            <div class="card-stock">
                                <div class="sold">Diskon {{ $product->diskon }}%</div>
                                Rp {{ number_format($product->total_harga, 0, ',', '.') }}
                                <div class="stock">Stok {{ $product->stok }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="main-right">
                <hr>
                <form method="POST" action="{{ route('transaksi.store') }}">
                    @csrf
                    <div class="order-list-container" id="orderListContainer"></div>
                    <hr>
                    <div class="ordered-info">
                        <input type="date" id="tanggal_bayar" name="tanggal_bayar" required>
                        <br>
                    </div>
                    <input type="hidden" name="total_harga" id="totalPriceInput" value="0">
                    <input type="hidden" name="qty" id="qtyInput" value="0">
                    <input type="hidden" name="orderList" id="orderListInput" value="[]">

                    <div class="total-transactions">
                        <div class="total">Total</div>
                        <div class="total-price" id="totalPrice">Rp0</div>
                    </div>
                    <div class="pay">
                        <div class="pay-title">Bayar RP</div>
                        <input type="number" name="pay" id="payInput" min="0" required>
                    </div>
                    <div class="return">
                        <div class="return-title">Kembalian</div>
                        <div class="return-amount-display" id="returnAmountDisplay">Rp0</div>
                        <input type="hidden" name="return_amount" id="returnAmountInput" value="0">
                    </div>
                    <br>
                    <div class="pay-action">
                        <button type="submit" class="pay-button">Proses</button>
                        <button type="button" class="cancel-button" onclick="window.location.href='{{ route('transaksi.index') }}'">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function searchMenu() {
            let searchInput = document.getElementById('searchInput').value.toLowerCase();
            let categoryFilter = document.getElementById('categoryFilter').value.toLowerCase();

            let cards = document.querySelectorAll('.card-container');
            cards.forEach(card => {
                let productName = card.querySelector('.card-title').innerText.toLowerCase();
                let productCategory = card.dataset.category.toLowerCase();

                let nameMatch = productName.includes(searchInput);
                let categoryMatch = (categoryFilter === 'all') || (productCategory === categoryFilter);

                if (nameMatch && categoryMatch) {
                card.style.display = 'block';
                } else {
                card.style.display = 'none';
                }
            });
            }

        // Set tanggal default untuk field Tanggal Bayar
        document.addEventListener("DOMContentLoaded", function () {
            const today = new Date();
            const formattedDate = today.toISOString().split('T')[0]; // Format YYYY-MM-DD
            document.getElementById('tanggal_bayar').value = formattedDate;
        });
        let orderList = [];
        let totalPrice = 0;

        function updateOrderListInput() {
            document.getElementById("orderListInput").value = JSON.stringify(orderList);
        }

        function addToOrder(id, name, price, stock) {
            let existingItem = orderList.find(item => item.id === id);
            if (existingItem) {
                if (existingItem.quantity < stock) {
                    existingItem.quantity++;
                    document.getElementById(`qty${id}`).innerText = `Jumlah ${existingItem.quantity}`;
                } else {
                    alert("Stok tidak cukup!");
                    return;
                }
            } else {
                if (stock > 0) {
                    orderList.push({ id, name, price, quantity: 1 });
                    let orderListContainer = document.getElementById("orderListContainer");
                    let cardOrder = document.createElement("div");
                    cardOrder.setAttribute("data-id", id);
                    cardOrder.classList.add("card-order");
                    cardOrder.innerHTML = `
                        <div class="info-menu">
                            <div class="name">${name}</div>
                            <div class="price">Rp${parseInt(price).toLocaleString('id-ID')}</div>
                        </div>
                        <div class="qty-order">
                            <div id="qty${id}" class="qty">Jumlah 1</div>
                            <button type="button" class="button-min" onclick="decreaseQty('${id}')">-</button>
                            <button type="button" class="button-plus" onclick="increaseQty('${id}')">+</button>
                        </div>`;
                    orderListContainer.appendChild(cardOrder);
                } else {
                    alert("Produk habis!");
                    return;
                }
            }
            updateOrderDisplay();
        }

        function increaseQty(id) {
            let selectedItem = orderList.find(item => item.id === id);
            if (selectedItem) {
                selectedItem.quantity++;
                document.getElementById(`qty${id}`).innerText = `Jumlah ${selectedItem.quantity}`;
                updateOrderDisplay();
            }
        }

        function decreaseQty(id) {
            let selectedItemIndex = orderList.findIndex(item => item.id === id);
            if (selectedItemIndex !== -1) {
                let selectedItem = orderList[selectedItemIndex];
                if (selectedItem.quantity > 1) {
                    selectedItem.quantity--;
                    document.getElementById(`qty${id}`).innerText = `Jumlah ${selectedItem.quantity}`;
                } else {
                    orderList.splice(selectedItemIndex, 1);
                    document.querySelector(`.card-order[data-id="${id}"]`).remove();
                }
                updateOrderDisplay();
            }
        }
        
        function updateOrderDisplay() {
            totalPrice = orderList.reduce((sum, item) => sum + (item.price * item.quantity), 0);
            document.getElementById("totalPrice").innerText = `Rp${totalPrice.toLocaleString('id-ID')}`;
            document.getElementById("totalPriceInput").value = totalPrice;
            document.getElementById("qtyInput").value = orderList.reduce((sum, item) => sum + item.quantity, 0);
            updateOrderListInput();
            calculateReturn();
        }

        function calculateReturn() {
            let payAmount = parseInt(document.getElementById("payInput").value) || 0;
            let returnAmount = payAmount - totalPrice;
            document.getElementById("returnAmountDisplay").innerText = `Rp${returnAmount.toLocaleString('id-ID')}`;
            document.getElementById("returnAmountInput").value = returnAmount;
            document.querySelector(".pay-button").disabled = returnAmount < 0 || orderList.length === 0;
        }

        document.getElementById("payInput").addEventListener("input", calculateReturn);

        function searchMenu() {
            let searchInput = document.getElementById("searchInput").value.toLowerCase();
            document.querySelectorAll('.card-container').forEach(item => {
                item.style.display = item.querySelector('.card-title').textContent.toLowerCase().includes(searchInput) ? 'block' : 'none';
            });
        }
    </script>
</body>
</html>