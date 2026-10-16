<?php
/**
 * Campaign Repository Interface
 *
 * @package ksfraser\CampaignBuilder\Repository
 * @author KSFII
 * @license MIT
 */

declare(strict_types=1);

namespace ksfraser\CampaignBuilder\Repository;

use ksfraser\CampaignBuilder\Entity\Campaign;
use ksfraser\CampaignBuilder\Entity\CampaignNode;
use ksfraser\CampaignBuilder\Entity\CampaignTrigger;

/**
 * Repository interface for campaign persistence
 */
interface CampaignRepositoryInterface
{
    /**
     * Save campaign
     */
    public function saveCampaign(Campaign $campaign): void;

    /**
     * Get campaign by ID
     */
    public function getCampaign(string $id): ?Campaign;

    /**
     * Delete campaign
     */
    public function deleteCampaign(string $id): void;

    /**
     * Get all campaigns
     */
    public function getAllCampaigns(): array;

    /**
     * Get active campaigns
     */
    public function findActiveCampaigns(): array;

    /**
     * Find campaigns by status
     */
    public function findByStatus(string $status): array;

    /**
     * Enroll contact in campaign
     */
    public function enrollContact(string $campaignId, string $contactId, array $data = []): void;

    /**
     * Get campaign contacts
     */
    public function getCampaignContacts(string $campaignId): array;

    /**
     * Update contact score
     */
    public function updateContactScore(string $contactId, int $change): void;

    /**
     * Add contact to segment
     */
    public function addToSegment(string $contactId, string $segmentId): void;

    /**
     * Queue email to send
     */
    public function queueEmail(string $emailId, string $contactId): void;

    /**
     * Schedule node execution
     */
    public function scheduleExecution(string $campaignId, string $nodeId, string $contactId, \DateTime $at): void;
}