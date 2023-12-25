class PlayerCard {
    constructor(ctx, color) {
        this.ctx = ctx;
        this.color = color;
        this.clubLogo = new Image();
        this.countryFlag = new Image();
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
    }

    setPosition(value) {
        this.ctx.font = '30px Arial';
        this.ctx.fillStyle = this.color;
        this.ctx.fillText(value, 90, 150);
    }

    setName(value) {
        this.ctx.font = 'bold 30px Arial';
        this.ctx.fillStyle = this.color;
        this.ctx.fillText(value, 167, 295);
    }

    setPac(value) {
        this.ctx.font = '23px Arial';
        this.ctx.fillStyle = this.color;
        this.ctx.fillText('PAC', 135, 340);

        this.ctx.font = 'bold 23px Arial';
        this.ctx.fillStyle = this.color;
        this.ctx.fillText(value, 95, 340);
    }

    setSho(value) {
        this.ctx.font = '23px Arial';
        this.ctx.fillStyle = this.color;
        this.ctx.fillText('SHO', 135, 370);

        this.ctx.font = 'bold 23px Arial';
        this.ctx.fillStyle = this.color;
        this.ctx.fillText(value, 95, 370);
    }

    setPas(value) {
        this.ctx.font = '23px Arial';
        this.ctx.fillStyle = this.color;
        this.ctx.fillText('PAS', 135, 400);

        this.ctx.font = 'bold 23px Arial';
        this.ctx.fillStyle = this.color;
        this.ctx.fillText(value, 95, 400);
    }

    setDef(value) {
        this.ctx.font = '23px Arial';
        this.ctx.fillStyle = this.color;
        this.ctx.fillText('DEF', 250, 370);

        this.ctx.font = 'bold 23px Arial';
        this.ctx.fillStyle = this.color;
        this.ctx.fillText(value, 210, 370);
    }

    setDri(value) {
        this.ctx.font = '23px Arial';
        this.ctx.fillStyle = this.color;
        this.ctx.fillText('DRI', 250, 340);

        this.ctx.font = 'bold 23px Arial';
        this.ctx.fillStyle = this.color;
        this.ctx.fillText(value, 210, 340);
    }

    setPhy(value) {
        this.ctx.font = '23px Arial';
        this.ctx.fillStyle = this.color;
        this.ctx.fillText('PHY', 250, 400);

        this.ctx.font = 'bold 23px Arial';
        this.ctx.fillStyle = this.color;
        this.ctx.fillText(value, 210, 400);
    }
}