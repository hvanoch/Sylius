<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Behat\Page\Admin\Customer;

use Sylius\Behat\Page\SymfonyPage;
use Webmozart\Assert\Assert;

/**
 * @author Magdalena Banasiak <magdalena.banasiak@lakion.com>
 */
class ShowPage extends SymfonyPage implements ShowPageInterface
{
    /**
     * {@inheritdoc}
     */
    public function isRegistered()
    {
        $username = $this->getDocument()->find('css', '#username');

        return null !== $username;
    }

    /**
     * {@inheritdoc}
     */
    public function deleteAccount()
    {
        $deleteButton = $this->getElement('delete_account_button');
        $deleteButton->press();

        $confirmationModal = $this->getDocument()->find('css', '#confirmation-modal');
        $this->waitForModalToAppear($confirmationModal, 'visible');
        $confirmationModal->find('css', '#confirmation-button')->press();
    }

    /**
     * {@inheritdoc}
     */
    public function getCustomerEmail()
    {
        return $this->getElement('customer_email')->getText();
    }

    /**
     * {@inheritdoc}
     */
    public function getCustomerName()
    {
        return $this->getElement('customer_name')->getText();
    }

    /**
     * {@inheritdoc}
     */
    public function getRegistrationDate()
    {
        return new \DateTime(str_replace('Customer since ', '', $this->getElement('registration_date')->getText()));
    }

    /**
     * {@inheritdoc}
     */
    public function getShippingAddress()
    {
        return $this->getElement('shipping_address')->getText();
    }

    /**
     * {@inheritdoc}
     */
    public function getBillingAddress()
    {
        return $this->getElement('billing_address')->getText();
    }

    /**
     * {@inheritdoc}
     */
    public function getRouteName()
    {
        return 'sylius_admin_customer_show';
    }

    /**
     * {@inheritdoc}
     */
    protected function getDefinedElements()
    {
        return array_merge(parent::getDefinedElements(), [
            'billing_address' => '#billingAddress address',
            'customer_email' => '#info .content.extra > a',
            'customer_name' => '#info .content > a',
            'delete_account_button' => '#actions button',
            'registration_date' => '#info .content .date',
            'shipping_address' => '#shippingAddress address',
        ]);
    }
}
