class PriceCalculator {
    constructor() {
        this.price = 0;
        this.currency = dependencies.currency;
        this.prices = dependencies.prices;
    }

    calculatePrice = (size, material) => this.prices.find(
        x => x.Size_Id == size && x.Material_Id == material)?.Price;

    getPrice = () => this.price;
    getPriceWithCurrency = () => `${this.price} ${this.currency}`;
    getCurrency = () => this.currency;
    
    setPrice = (size, material) => this.price = this.calculatePrice(size, material);
}