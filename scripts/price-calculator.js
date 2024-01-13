class PriceCalculator {
    constructor() {
        this.price = 0;
        this.currency = dependencies.currency;
        
        this.priceConfig = [
            {size: "small", material: "pvc", price: 40},
            {size: "small", material: "metal", price: 60},
            {size: "medium", material: "pvc", price: 50},
            {size: "medium", material: "metal", price: 80},
            {size: "large", material: "pvc", price: 65},
            {size: "large", material: "metal", price: 85}
        ];
    }

    calculatePrice = (size, material) => this.priceConfig.find(
        item => item.size === size && item.material === material)?.price;

    getPrice = () => this.price;
    getPriceWithCurrency = () => `${this.price} ${this.currency}`;
    getCurrency = () => this.currency;
    
    setPrice = (size, material) => this.price = this.calculatePrice(size, material);
}