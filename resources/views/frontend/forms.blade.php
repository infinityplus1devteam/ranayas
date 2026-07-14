<form action="{{ route('cart.delete', [], false) }}" id="frmDeleteItem" method="POST">
    @csrf
    <input type="hidden" name="item_id" required="required" id="hiddenFieldDeleteItemId" />
</form>

<form action="{{ route('wishlist.add', [], false) }}" id="frmAddWishlist" method="POST">
    @csrf
    <input type="hidden" name="p_id" id="txtProductId" />
    <input type="hidden" name="c_id" id="txtColorId" />
    <input type="hidden" name="s_id" id="txtSizeId" />
</form>

<form action="{{ route('wishlist.remove', [], false) }}" id="frmRemoveWishlist" method="POST">
    @csrf
    <input type="hidden" name="w_id" id="txtWishlistId" />
</form>

<form action="{{ route('cart.store', [], false) }}" method="post" id="cartForm">
    @csrf
    <input type="hidden" name="prod_id" id="cart_prod_id">
    <input type="hidden" name="qty" id="cart_qty">
    <input type="hidden" name="color_id" id="cart_color_id">
    <input type="hidden" name="size_id" id="cart_size_id">
</form>