<?php

class EmergencyContactsDataModel extends DataModel
{
    protected $cacheFolder = 'ContactsList';
    protected $primaryContacts = NULL;
    protected $secondaryContects = NULL;
    protected $contactsLoaded = false;

    public static function getContactsListDataRetrievers() {
        return array(
            'DrupalContactsDataRetriever'=>'Drupal Module',
            'INIFileContactsListRetriever'=>'INI File'
        );
    }

    public function getItem($id)
    {
        $this->loadContacts();
        foreach ($this->primaryContacts as $contact) {
            if($contact->getTitle() == $id) {
                return $contact;
            }
        }

        foreach ($this->secondaryContacts as $contact) {
            if($contact->getTitle() == $id) {
                return $contact;
            }
        }

        return NULL;
    }

    public function getPrimaryContacts() {
        $this->loadContacts();
        return $this->primaryContacts;
    }

    public function getSecondaryContacts() {
        $this->loadContacts();
        return $this->secondaryContacts;
    }

    public function hasSecondaryContacts() {
        $this->loadContacts();
        return (count($this->secondaryContacts) > 0);
    }

    public function getAllContacts() {
        $this->loadContacts();
        return array_merge($this->primaryContacts, $this->secondaryContacts);
    }

    protected function loadContacts() {
        if (!$this->contactsLoaded) {
            $contacts = $this->getData();
            $this->primaryContacts = $contacts['primary'];
            $this->secondaryContacts = $contacts['secondary'];
        }
    }
}