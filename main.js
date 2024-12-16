//=============================================================================
// Configuration
//=============================================================================
const GPAY_BUTTON_CONTAINER_ID = 'gpay-container';

const merchantInfo = {
  merchantId: 'BCR2DN4T26SODXZH',
  merchantName: 'Le chanvre d ici'
};

const baseGooglePayRequest = {
  apiVersion: 2,
  apiVersionMinor: 0,
  allowedPaymentMethods: [
    {
      type: 'CARD',
      parameters: {
        allowedAuthMethods: ["PAN_ONLY", "CRYPTOGRAM_3DS"],
        allowedCardNetworks: ["AMEX", "DISCOVER", "INTERAC", "JCB", "MASTERCARD", "VISA"]
      },
      tokenizationSpecification: {
        type: 'PAYMENT_GATEWAY',
        parameters: {
          gateway: 'example',
          gatewayMerchantId: 'exampleGatewayMerchantId'
        }
      }
    }
  ],
  merchantInfo
};

//=============================================================================
// Google Payments client singleton
//=============================================================================
let paymentsClient = null;

function getGooglePaymentsClient() {
  if (paymentsClient === null) {
    paymentsClient = new google.payments.api.PaymentsClient({
      environment: 'TEST',
      merchantInfo,
    });
  }
  return paymentsClient;
}

//=============================================================================
// Helpers
//=============================================================================
const deepCopy = (obj) => JSON.parse(JSON.stringify(obj));

function renderGooglePayButton() {
  const button = getGooglePaymentsClient().createButton({
    onClick: onGooglePaymentButtonClicked
  });

  document.getElementById(GPAY_BUTTON_CONTAINER_ID).appendChild(button);
}

//=============================================================================
// Event Handlers
//=============================================================================
function onGooglePayLoaded() {
  const req = deepCopy(baseGooglePayRequest);

  getGooglePaymentsClient()
    .isReadyToPay(req)
    .then(function(res) {
      if (res.result) {
        renderGooglePayButton();
      } else {
        console.log("Google Pay is not ready for this user.");
      }
    })
    .catch(console.error);
}

function onGooglePaymentButtonClicked() {
  // Créer une nouvelle requête en copiant la configuration de base
  const req = {
    ...deepCopy(baseGooglePayRequest),
    transactionInfo: {
      countryCode: 'FR',
      currencyCode: 'EUR',
      totalPriceStatus: 'FINAL',
      totalPrice: window.cartTotalPrice || '0.00', // Utiliser le total du panier du premier fichier
    },
  };

  // Affichage de la requête pour déboguer
  console.log(req);

  getGooglePaymentsClient()
    .loadPaymentData(req)
    .then(function (res) {
      // Traitement de la réponse
      console.log(res);
      // Utiliser le token de paiement pour traiter le paiement avec votre passerelle
      const paymentToken = res.paymentMethodData.tokenizationData.token;
    })
    .catch(console.error);
}
