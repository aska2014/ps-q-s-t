<?php namespace Migs;

class MigsRequest {

    /**
     * @var MigsGenerator
     */
    protected $generator;

    /**
     * @var MigsAccount
     */
    protected $account;

    /**
     * @param MigsGenerator $generator
     * @param MigsAccount $account
     */
    public function __construct(MigsGenerator $generator, MigsAccount $account)
    {
        $this->generator = $generator;
        $this->account = $account;
    }

    /**
     * @return array
     */
    public function getRequestData()
    {
        return $this->generator->getQueryData($this->account);
    }

    /**
     * @todo This method should take the order
     */
    public function simplePaymentUrl($returnUrl = '')
    {
        $queryData = $this->generator->getQueryData($this->account, $returnUrl);

        return $this->getUrl($queryData);
    }

    /**
     * @param array $params
     * @return string
     */
    public function getUrl(array $params = array())
    {
        return 'https://migs.mastercard.com.au/vpcpay?'.http_build_query($params);
    }
}