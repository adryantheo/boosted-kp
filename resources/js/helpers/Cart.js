var Cart = Object.freeze({
    cartItems: [],
    helpers: {
        addToCart(item) {
            item.qty++

            const { id, name, price, qty } = item
            
            const inCartIdx = this.cartItems.findIndex(obj => {
                return obj.id == item.id
            });

            if(!!(inCartIdx+1)) {
                this.cartItems[inCartIdx].qty++
            } else {
                const newItem = {
                    id: id,
                    name: name,
                    price: price,
                    qty: qty,
                }

                this.cartItems.push(newItem)
            }
            
        },
        removeFromCart(item) {
            item.qty--

            const inCartIdx = this.cartItems.findIndex(obj => {
                return obj.id == item.id
            });

            if(!!(inCartIdx+1)) {
                if( (this.cartItems[inCartIdx].qty - 1) <= 0 )
                    this.cartItems.splice(inCartIdx, 1)
                else
                    this.cartItems[inCartIdx].qty--
            }
        },
    }
})

export default Cart