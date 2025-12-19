/* global PayPal */
import '../styles/progress.scss';
import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
  static targets = ['buttonContainer'];
  static values = {
    hostedButtonId: String,
    onCompleteCallback: String,
    dev: Boolean,
  };

  initialize() {
    PayPal.Donation.Button({
      env: this.devValue ? 'sandbox' : 'production',
      hosted_button_id: this.hostedButtonIdValue,
      image: {
        src: 'https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif',
        alt: 'Donate with PayPal button',
        title: 'PayPal - The safer, easier way to pay online!',
      },
      onComplete: this.registerDonation.bind(this),
    }).render('#' + this.buttonContainerTarget.id);
  }

  registerDonation(data) {
    console.log('yeeting it', data);
    fetch(this.onCompleteCallbackValue, {
      method: 'POST',
      body: JSON.stringify(data),
    });
  }
}
