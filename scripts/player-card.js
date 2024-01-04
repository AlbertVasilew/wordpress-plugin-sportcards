class PlayerCard {
    constructor(ctx, color) {
        this.ctx = ctx;
        this.color = color;
        this.clubLogo = new Image();
        this.countryFlag = new Image();
        
        this.material = null;
        this.size = null;
        this.rating = null;
        this.position = null;
        this.name = null;
        this.pac = null;
        this.sho = null;
        this.pas = null;
        this.dri = null;
        this.def = null;
        this.phy = null;
    }

    setMaterial(value) {
        this.material = value;
    }

    setSize(value) {
        this.size = value;
    }

    setColor(value) {
        this.color = value;
    }

    setClubLogo(value) {
        this.clubLogo.src = value;
        this.clubLogo.onload = () => {
            this.ctx.drawImage(this.clubLogo, 90, 210, 40, 50);
        }
    }

    setCountryFlag(value) {
        this.countryFlag.src = value;
        this.countryFlag.onload = () => {
            this.ctx.drawImage(this.countryFlag, 90, 165, 40, 25);
        }
    }

    setRating(value) {
        this.ctx.font = 'bold 35px Arial';
        this.ctx.fillStyle = this.color;
        this.ctx.fillText(value, 90, 115);
        this.rating = value;
    }

    setPosition(value) {
        this.ctx.font = '30px Arial';
        this.ctx.fillStyle = this.color;
        this.ctx.fillText(value, 90, 150);
        this.position = value;
    }

    setName(value) {
        this.ctx.font = 'bold 30px Arial';
        this.ctx.fillStyle = this.color;
        this.ctx.fillText(value, 167, 295);
        this.name = value;
    }

    setPac(value) {
        this.ctx.font = '23px Arial';
        this.ctx.fillStyle = this.color;
        this.ctx.fillText('PAC', 135, 340);

        this.ctx.font = 'bold 23px Arial';
        this.ctx.fillStyle = this.color;
        this.ctx.fillText(value, 95, 340);

        this.pac = value;
    }

    setSho(value) {
        this.ctx.font = '23px Arial';
        this.ctx.fillStyle = this.color;
        this.ctx.fillText('SHO', 135, 370);

        this.ctx.font = 'bold 23px Arial';
        this.ctx.fillStyle = this.color;
        this.ctx.fillText(value, 95, 370);

        this.sho = value;
    }

    setPas(value) {
        this.ctx.font = '23px Arial';
        this.ctx.fillStyle = this.color;
        this.ctx.fillText('PAS', 135, 400);

        this.ctx.font = 'bold 23px Arial';
        this.ctx.fillStyle = this.color;
        this.ctx.fillText(value, 95, 400);

        this.pas = value;
    }

    setDef(value) {
        this.ctx.font = '23px Arial';
        this.ctx.fillStyle = this.color;
        this.ctx.fillText('DEF', 250, 370);

        this.ctx.font = 'bold 23px Arial';
        this.ctx.fillStyle = this.color;
        this.ctx.fillText(value, 210, 370);

        this.def = value;
    }

    setDri(value) {
        this.ctx.font = '23px Arial';
        this.ctx.fillStyle = this.color;
        this.ctx.fillText('DRI', 250, 340);

        this.ctx.font = 'bold 23px Arial';
        this.ctx.fillStyle = this.color;
        this.ctx.fillText(value, 210, 340);

        this.dri = value;
    }

    setPhy(value) {
        this.ctx.font = '23px Arial';
        this.ctx.fillStyle = this.color;
        this.ctx.fillText('PHY', 250, 400);

        this.ctx.font = 'bold 23px Arial';
        this.ctx.fillStyle = this.color;
        this.ctx.fillText(value, 210, 400);

        this.phy = value;
    }

    getCardData() {
        return {
            material: this.material,
            size: this.size,
            rating: this.rating,
            position: this.position,
            name: this.name
        }
    }
}