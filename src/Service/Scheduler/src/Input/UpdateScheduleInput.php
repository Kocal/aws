<?php

namespace AsyncAws\Scheduler\Input;

use AsyncAws\Core\Exception\InvalidArgument;
use AsyncAws\Core\Input;
use AsyncAws\Core\Request;
use AsyncAws\Core\Stream\StreamFactory;
use AsyncAws\Scheduler\Enum\ScheduleState;
use AsyncAws\Scheduler\ValueObject\FlexibleTimeWindow;
use AsyncAws\Scheduler\ValueObject\Target;

final class UpdateScheduleInput extends Input
{
    /**
     * Unique, case-sensitive identifier you provide to ensure the idempotency of the request. If you do not specify a
     * client token, EventBridge Scheduler uses a randomly generated token for the request to ensure idempotency.
     *
     * @var string|null
     */
    private $clientToken;

    /**
     * The description you specify for the schedule.
     *
     * @var string|null
     */
    private $description;

    /**
     * The date, in UTC, before which the schedule can invoke its target. Depending on the schedule's recurrence expression,
     * invocations might stop on, or before, the `EndDate` you specify. EventBridge Scheduler ignores `EndDate` for one-time
     * schedules.
     *
     * @var \DateTimeImmutable|null
     */
    private $endDate;

    /**
     * Allows you to configure a time window during which EventBridge Scheduler invokes the schedule.
     *
     * @required
     *
     * @var FlexibleTimeWindow|null
     */
    private $flexibleTimeWindow;

    /**
     * The name of the schedule group with which the schedule is associated. You must provide this value in order for
     * EventBridge Scheduler to find the schedule you want to update. If you omit this value, EventBridge Scheduler assumes
     * the group is associated to the default group.
     *
     * @var string|null
     */
    private $groupName;

    /**
     * The ARN for the customer managed KMS key that that you want EventBridge Scheduler to use to encrypt and decrypt your
     * data.
     *
     * @var string|null
     */
    private $kmsKeyArn;

    /**
     * The name of the schedule that you are updating.
     *
     * @required
     *
     * @var string|null
     */
    private $name;

    /**
     * The expression that defines when the schedule runs. The following formats are supported.
     *
     * @required
     *
     * @var string|null
     */
    private $scheduleExpression;

    /**
     * The timezone in which the scheduling expression is evaluated.
     *
     * @var string|null
     */
    private $scheduleExpressionTimezone;

    /**
     * The date, in UTC, after which the schedule can begin invoking its target. Depending on the schedule's recurrence
     * expression, invocations might occur on, or after, the `StartDate` you specify. EventBridge Scheduler ignores
     * `StartDate` for one-time schedules.
     *
     * @var \DateTimeImmutable|null
     */
    private $startDate;

    /**
     * Specifies whether the schedule is enabled or disabled.
     *
     * @var ScheduleState::*|null
     */
    private $state;

    /**
     * The schedule target. You can use this operation to change the target that your schedule invokes.
     *
     * @required
     *
     * @var Target|null
     */
    private $target;

    /**
     * @param array{
     *   ClientToken?: string,
     *   Description?: string,
     *   EndDate?: \DateTimeImmutable|string,
     *   FlexibleTimeWindow?: FlexibleTimeWindow|array,
     *   GroupName?: string,
     *   KmsKeyArn?: string,
     *   Name?: string,
     *   ScheduleExpression?: string,
     *   ScheduleExpressionTimezone?: string,
     *   StartDate?: \DateTimeImmutable|string,
     *   State?: ScheduleState::*,
     *   Target?: Target|array,
     *   @region?: string,
     * } $input
     */
    public function __construct(array $input = [])
    {
        $this->clientToken = $input['ClientToken'] ?? null;
        $this->description = $input['Description'] ?? null;
        $this->endDate = !isset($input['EndDate']) ? null : ($input['EndDate'] instanceof \DateTimeImmutable ? $input['EndDate'] : new \DateTimeImmutable($input['EndDate']));
        $this->flexibleTimeWindow = isset($input['FlexibleTimeWindow']) ? FlexibleTimeWindow::create($input['FlexibleTimeWindow']) : null;
        $this->groupName = $input['GroupName'] ?? null;
        $this->kmsKeyArn = $input['KmsKeyArn'] ?? null;
        $this->name = $input['Name'] ?? null;
        $this->scheduleExpression = $input['ScheduleExpression'] ?? null;
        $this->scheduleExpressionTimezone = $input['ScheduleExpressionTimezone'] ?? null;
        $this->startDate = !isset($input['StartDate']) ? null : ($input['StartDate'] instanceof \DateTimeImmutable ? $input['StartDate'] : new \DateTimeImmutable($input['StartDate']));
        $this->state = $input['State'] ?? null;
        $this->target = isset($input['Target']) ? Target::create($input['Target']) : null;
        parent::__construct($input);
    }

    public static function create($input): self
    {
        return $input instanceof self ? $input : new self($input);
    }

    public function getClientToken(): ?string
    {
        return $this->clientToken;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getEndDate(): ?\DateTimeImmutable
    {
        return $this->endDate;
    }

    public function getFlexibleTimeWindow(): ?FlexibleTimeWindow
    {
        return $this->flexibleTimeWindow;
    }

    public function getGroupName(): ?string
    {
        return $this->groupName;
    }

    public function getKmsKeyArn(): ?string
    {
        return $this->kmsKeyArn;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getScheduleExpression(): ?string
    {
        return $this->scheduleExpression;
    }

    public function getScheduleExpressionTimezone(): ?string
    {
        return $this->scheduleExpressionTimezone;
    }

    public function getStartDate(): ?\DateTimeImmutable
    {
        return $this->startDate;
    }

    /**
     * @return ScheduleState::*|null
     */
    public function getState(): ?string
    {
        return $this->state;
    }

    public function getTarget(): ?Target
    {
        return $this->target;
    }

    /**
     * @internal
     */
    public function request(): Request
    {
        // Prepare headers
        $headers = ['content-type' => 'application/json'];

        // Prepare query
        $query = [];

        // Prepare URI
        $uri = [];
        if (null === $v = $this->name) {
            throw new InvalidArgument(sprintf('Missing parameter "Name" for "%s". The value cannot be null.', __CLASS__));
        }
        $uri['Name'] = $v;
        $uriString = '/schedules/' . rawurlencode($uri['Name']);

        // Prepare Body
        $bodyPayload = $this->requestBody();
        $body = empty($bodyPayload) ? '{}' : json_encode($bodyPayload, 4194304);

        // Return the Request
        return new Request('PUT', $uriString, $query, $headers, StreamFactory::create($body));
    }

    public function setClientToken(?string $value): self
    {
        $this->clientToken = $value;

        return $this;
    }

    public function setDescription(?string $value): self
    {
        $this->description = $value;

        return $this;
    }

    public function setEndDate(?\DateTimeImmutable $value): self
    {
        $this->endDate = $value;

        return $this;
    }

    public function setFlexibleTimeWindow(?FlexibleTimeWindow $value): self
    {
        $this->flexibleTimeWindow = $value;

        return $this;
    }

    public function setGroupName(?string $value): self
    {
        $this->groupName = $value;

        return $this;
    }

    public function setKmsKeyArn(?string $value): self
    {
        $this->kmsKeyArn = $value;

        return $this;
    }

    public function setName(?string $value): self
    {
        $this->name = $value;

        return $this;
    }

    public function setScheduleExpression(?string $value): self
    {
        $this->scheduleExpression = $value;

        return $this;
    }

    public function setScheduleExpressionTimezone(?string $value): self
    {
        $this->scheduleExpressionTimezone = $value;

        return $this;
    }

    public function setStartDate(?\DateTimeImmutable $value): self
    {
        $this->startDate = $value;

        return $this;
    }

    /**
     * @param ScheduleState::*|null $value
     */
    public function setState(?string $value): self
    {
        $this->state = $value;

        return $this;
    }

    public function setTarget(?Target $value): self
    {
        $this->target = $value;

        return $this;
    }

    private function requestBody(): array
    {
        $payload = [];
        if (null === $v = $this->clientToken) {
            $v = uuid_create(\UUID_TYPE_RANDOM);
        }
        $payload['ClientToken'] = $v;
        if (null !== $v = $this->description) {
            $payload['Description'] = $v;
        }
        if (null !== $v = $this->endDate) {
            $payload['EndDate'] = $v->format(\DateTimeInterface::ATOM);
        }
        if (null === $v = $this->flexibleTimeWindow) {
            throw new InvalidArgument(sprintf('Missing parameter "FlexibleTimeWindow" for "%s". The value cannot be null.', __CLASS__));
        }
        $payload['FlexibleTimeWindow'] = $v->requestBody();
        if (null !== $v = $this->groupName) {
            $payload['GroupName'] = $v;
        }
        if (null !== $v = $this->kmsKeyArn) {
            $payload['KmsKeyArn'] = $v;
        }

        if (null === $v = $this->scheduleExpression) {
            throw new InvalidArgument(sprintf('Missing parameter "ScheduleExpression" for "%s". The value cannot be null.', __CLASS__));
        }
        $payload['ScheduleExpression'] = $v;
        if (null !== $v = $this->scheduleExpressionTimezone) {
            $payload['ScheduleExpressionTimezone'] = $v;
        }
        if (null !== $v = $this->startDate) {
            $payload['StartDate'] = $v->format(\DateTimeInterface::ATOM);
        }
        if (null !== $v = $this->state) {
            if (!ScheduleState::exists($v)) {
                throw new InvalidArgument(sprintf('Invalid parameter "State" for "%s". The value "%s" is not a valid "ScheduleState".', __CLASS__, $v));
            }
            $payload['State'] = $v;
        }
        if (null === $v = $this->target) {
            throw new InvalidArgument(sprintf('Missing parameter "Target" for "%s". The value cannot be null.', __CLASS__));
        }
        $payload['Target'] = $v->requestBody();

        return $payload;
    }
}
