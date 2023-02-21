const PluginManager = window.PluginManager;

import Plugin from 'src/plugin-system/plugin.class';
import DomAccess from 'src/helper/dom-access.helper';
import HttpClient from 'src/service/http-client.service';

class XrpPayment  extends Plugin {
    init() {
        console.log('Xrpl-Connector XrpPayment - init');
        window.DomAccess = DomAccess;

        this.client = new HttpClient();

        this.checkPaymentButton = DomAccess.querySelector(document, '#check-payment-button');

        this.checkPaymentButton.onclick = this._fetchPaymentData.bind(this);
        window.checkPaymentButton  = this.checkPaymentButton;

        //process.env.NODE_ENV
    }

    _registerEvents() {
        this.checkPaymentButton.onclick = this._fetchPaymentData.bind(this);
    }

    _fetchPaymentData() {
        const orderId = this.checkPaymentButton.dataset.orderId;
        this.client.get('/xrpl-connector/check-payment/' + orderId , this._handlePaymentData.bind(this), 'application/json', true);
    }

    _handlePaymentData(data) {
        console.log(JSON.parse(data).success);
    }
}

PluginManager.register(
    'XrpPayment',
    XrpPayment,
    '[data-xrp-payment]'
);