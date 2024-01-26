class PlayerCard {
    constructor(canvas, context) {
        this.canvas = canvas;
        this.ctx = context;
        this.playerImage = new Image();
        this.cardImage = new Image();
        this.clubLogo = new Image();
        this.countryFlag = new Image();
        this.countryFlag.crossOrigin = 'anonymous';
        this.clubLogo.crossOrigin = 'anonymous';

        this.pac = {}, this.sho = {}, this.pas = {}, this.def = {}, this.dri = {}, this.phy = {},
        this.div = {}, this.han = {}, this.kic = {}, this.ref = {}, this.spe = {}, this.pos = {},
        this.position = {}, this.size = {}, this.material = {}, this.name = {}, this.rating = {},
        this.customClubLogoExternal = {};
    }

    setImageSourceHandler = (image, source, properties) => {
        if (!source) return;

        image.src = source;
        image.onload = () => this.ctx.drawImage(image, properties.x, properties.y, properties.width, properties.height);
    }

    setText = (object, value, properties) => {
        if (object != null)
            object.value = value;

        this.ctx.font = properties.font;
        this.ctx.fillText(value, properties.x, properties.y);
    }

    setMaterial = value => this.material.value = value;
    setSize = value => this.size.value = value;
    setColor = value => this.ctx.fillStyle = value;
    setRating = value => this.setText(this.rating, value, {font: 'bold 35px Arial', x: 90, y: 115});
    setPosition = value => this.setText(this.position, value, {font: '30px Arial', x: 90, y: 150});
    setClubLogo = value => this.setImageSourceHandler(this.clubLogo, value, {x: 90, y: 210, width: 40, height: 50});
    setCardImage = value => this.cardImage.src = value;

    setCharHeading = (value, properties) =>
        this.setText(null, value, {font: '23px Arial', x: properties.x, y: properties.y});

    setCharValue = (object, value, properties) => 
        this.setText(object, value, {font: 'bold 23px Arial', x: properties.x, y: properties.y});

    setPlayerImage = value =>
        this.setImageSourceHandler(this.playerImage, value, {x: 165, y: 90, width: 180, height: 180});

    setCountryFlag = value =>
        this.setImageSourceHandler(this.countryFlag, value, {x: 90, y: 165, width: 40, height: 25});

    setName = value => this.setText(
        this.name,
        value,
        {font: 'bold 30px Arial', x: (this.ctx.canvas.width - this.ctx.measureText(value).width) / 1.75, y: 295}
    );

    setPac = value => {
        this.setCharHeading('PAC', {x: 135, y: 340});
        this.setCharValue(this.pac, value, {x: 95, y: 340});
    }

    setSho = value => {
        this.setCharHeading('SHO', {x: 135, y: 370});
        this.setCharValue(this.sho, value, {x: 95, y: 370});
    }

    setPas = value => {
        this.setCharHeading('PAS', {x: 135, y: 400});
        this.setCharValue(this.pas, value, {x: 95, y: 400});
    }

    setDef = value => {
        this.setCharHeading('DEF', {x: 250, y: 370});
        this.setCharValue(this.def, value, {x: 210, y: 370});
    }

    setDri = value => {
        this.setCharHeading('DRI', {x: 250, y: 340});
        this.setCharValue(this.dri, value, {x: 210, y: 340});
    }

    setPhy = value => {
        this.setCharHeading('PHY', {x: 250, y: 400});
        this.setCharValue(this.phy, value, {x: 210, y: 400});
    }

    setDiv = value => {
        this.setCharHeading('DIV', {x: 135, y: 340});
        this.setCharValue(this.div, value, {x: 95, y: 340});
    }

    setHan = value => {
        this.setCharHeading('HAN', {x: 135, y: 370});
        this.setCharValue(this.han, value, {x: 95, y: 370});
    }

    setKic = value => {
        this.setCharHeading('KIC', {x: 135, y: 400});
        this.setCharValue(this.kic, value, {x: 95, y: 400});
    }

    setSpe = value => {
        this.setCharHeading('SPE', {x: 250, y: 370});
        this.setCharValue(this.spe, value, {x: 210, y: 370});
    }

    setRef = value => {
        this.setCharHeading('REF', {x: 250, y: 340});
        this.setCharValue(this.ref, value, {x: 210, y: 340});
    }

    setPos = value => {
        this.setCharHeading('POS', {x: 250, y: 400});
        this.setCharValue(this.pos, value, {x: 210, y: 400});
    }

    setCustomClubLogoExternal = value => this.customClubLogoExternal.value = value;

    getCardImage = () => this.cardImage;

    getCardData = () => ({
        material: this.material?.value,
        size: this.size?.value,
        color: this.ctx.fillStyle,
        rating: this.rating?.value,
        position: this.position?.value,
        name: this.name?.value,
        pac: this.pac?.value,
        sho: this.sho?.value,
        pas: this.pas?.value,
        def: this.def?.value,
        dri: this.dri?.value,
        phy: this.phy?.value,
        div: this.div?.value,
        han: this.han?.value,
        kic: this.kic?.value,
        ref: this.ref?.value,
        spe: this.spe?.value,
        pos: this.pos?.value,
        customizedCardImageUrl: this.canvas.toDataURL(),
        playerImageUrl: this.playerImage.src,
        cardImageUrl: this.cardImage.src,
        countryFlagUrl: this.countryFlag.src,
        clubLogoUrl: this.customClubLogoExternal.value ? this.customClubLogoExternal.value : this.clubLogo.src
    });
}