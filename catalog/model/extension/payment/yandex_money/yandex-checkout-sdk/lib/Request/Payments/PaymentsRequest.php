<?php

namespace YaMoney\Request\Payments;

use YaMoney\Common\AbstractRequest;
use YaMoney\Common\Exceptions\InvalidPropertyValueException;
use YaMoney\Common\Exceptions\InvalidPropertyValueTypeException;
use YaMoney\Helpers\TypeCast;
use YaMoney\Model\Status;

/**
 * Класс объекта запроса к API для получения списка платежей магазина
 *
 * @property string|null $paymentId Идентификатор платежа
 * @property string|null $accountId Идентификатор магазина
 * @property string|null $gatewayId Идентификатор шлюза
 * @property \DateTime|null $createdGte Время создания, от (включительно)
 * @property \DateTime|null $createdGt Время создания, от (не включая)
 * @property \DateTime|null $createdLte Время создания, до (включительно)
 * @property \DateTime|null $createdLt Время создания, до (не включая)
 * @property \DateTime|null $authorizedGte Время проведения операции, от (включительно)
 * @property \DateTime|null $authorizedGt Время проведения операции, от (не включая)
 * @property \DateTime|null $authorizedLte Время проведения, до (включительно)
 * @property \DateTime|null $authorizedLt Время проведения, до (не включая)
 * @property string|null $status Статус платежа
 * @property string|null $nextPage Токен для получения следующей страницы выборки
 */
class PaymentsRequest extends AbstractRequest implements PaymentsRequestInterface
{
    /**
     * @var string Идентификатор платежа
     */
    private $_paymentId;

    /**
     * @var string Идентификатор магазина
     */
    private $_accountId;

    /**
     * @var string Идентификатор шлюза
     */
    private $_gatewayId;

    /**
     * @var \DateTime Время создания, от (включительно)
     */
    private $_createdGte;

    /**
     * @var \DateTime Время создания, от (не включая)
     */
    private $_createdGt;

    /**
     * @var \DateTime Время создания, до (включительно)
     */
    private $_createdLte;

    /**
     * @var \DateTime Время создания, до (не включая)
     */
    private $_createdLt;

    /**
     * @var \DateTime Время проведения операции, от (включительно)
     */
    private $_authorizedGte;

    /**
     * @var \DateTime Время проведения операции, от (не включая)
     */
    private $_authorizedGt;

    /**
     * @var \DateTime Время проведения, до (включительно)
     */
    private $_authorizedLte;

    /**
     * @var \DateTime Время проведения, до (не включая)
     */
    private $_authorizedLt;

    /**
     * @var string Статус платежа
     */
    private $_status;

    /**
     * @var string Токен для получения следующей страницы выборки
     */
    private $_nextPage;

    /**
     * Возвращает инстанс билдера объектов запросов списка платежей магазина
     * @return PaymentsRequestBuilder Билдер объектов запросов списка платежей
     */
    public static function builder()
    {
        return new PaymentsRequestBuilder();
    }

    /**
     * Возвращает идентификатор платежа если он задан или null
     * @return string|null Идентификатор платежа
     */
    public function getPaymentId()
    {
        return $this->_paymentId;
    }

    /**
     * Устанавливает идентификатор платежа или null если требуется его удалить
     * @param string|null $value Идентификатор платежа
     *
     * @throws InvalidPropertyValueException Выбрасывается если длина переданной строки не равна 36 символам
     * @throws InvalidPropertyValueTypeException Выбрасывается если в метод была передана не строка
     */
    public function setPaymentId($value)
    {
        if ($value === null || $value === '') {
            $this->_paymentId = null;
        } elseif (TypeCast::canCastToString($value)) {
            $length = mb_strlen((string)$value, 'utf-8');
            if ($length != 36) {
                throw new InvalidPropertyValueException(
                    'Invalid payment_id value length in PaymentsRequest (' . $length . ' != 36)',
                    0, 'PaymentsRequest.paymentId', $value
                );
            }
            $this->_paymentId = (string)$value;
        } else {
            throw new InvalidPropertyValueTypeException(
                'Invalid payment_id value type in PaymentsRequest', 0, 'PaymentsRequest.paymentId', $value
            );
        }
    }

    /**
     * Проверяет, был ли задан идентификатор платежа
     * @return bool True если идентификатор был задан, false если нет
     */
    public function hasPaymentId()
    {
        return $this->_paymentId !== null;
    }

    /**
     * Возвращает идентификатор магазина, если он был задан
     * @return string|null Идентификатор магазина
     */
    public function getAccountId()
    {
        return $this->_accountId;
    }

    /**
     * Устанавлвиает идентификатор магазина
     * @param string $value Идентификатор магазина или null чтобы удалить значение
     *
     * @throws InvalidPropertyValueTypeException Выбрасывается если в метод была передана не строка
     */
    public function setAccountId($value)
    {
        if ($value === null || $value === '') {
            $this->_accountId = null;
        } elseif (TypeCast::canCastToString($value)) {
            $this->_accountId = (string)$value;
        } else {
            throw new InvalidPropertyValueTypeException(
                'Invalid accountId value type in PaymentsRequest', 0, 'PaymentsRequest.accountId', $value
            );
        }
    }

    /**
     * Проверяет, был ли установлен идентификатор магазина
     * @return bool True если идентификатор магазина был установлен, false если нет
     */
    public function hasAccountId()
    {
        return $this->_accountId !== null;
    }

    /**
     * Возвращает идентификатор шлюза
     * @return string|null Идентификатор шлюза
     */
    public function getGatewayId()
    {
        return $this->_gatewayId;
    }

    /**
     * Устанавливает идентификатор шлюза
     * @param string|null $value Идентификатор шлюза или null чтобы удалить значение
     *
     * @throws InvalidPropertyValueTypeException Выбрасывается если в метод была передана не строка
     */
    public function setGatewayId($value)
    {
        if ($value === null || $value === '') {
            $this->_gatewayId = null;
        } elseif (TypeCast::canCastToString($value)) {
            $this->_gatewayId = (string)$value;
        } else {
            throw new InvalidPropertyValueTypeException(
                'Invalid gatewayId value type in PaymentsRequest', 0, 'PaymentsRequest.gatewayId', $value
            );
        }
    }

    /**
     * Проверяет был ли установлен идентификатор шлюза
     * @return bool True если идентификатор шлюза был установлен, false если нет
     */
    public function hasGatewayId()
    {
        return $this->_gatewayId !== null;
    }

    /**
     * Возвращает дату создания от которой будут возвращены платежи или null если дата не была установлена
     * @return \DateTime|null Время создания, от (включительно)
     */
    public function getCreatedGte()
    {
        return $this->_createdGte;
    }

    /**
     * Устанавливает дату создания от которой выбираются платежи
     * @param \DateTime|string|int|null $value Время создания, от (включительно) или null чтобы удалить значение
     *
     * @throws InvalidPropertyValueException Генерируется если была передана дата в невалидном формате (была передана
     * строка или число, которые не удалось преобразовать в валидную дату)
     * @throws InvalidPropertyValueTypeException Генерируется если была передана дата с не тем типом (передана не
     * строка, не число и не значение типа \DateTime)
     */
    public function setCreatedGte($value)
    {
        if ($value === null || $value === '') {
            $this->_createdGte = null;
        } elseif (TypeCast::canCastToDateTime($value)) {
            $dateTime = TypeCast::castToDateTime($value);
            if ($dateTime === null) {
                throw new InvalidPropertyValueException(
                    'Invalid created_gte value in PaymentsRequest', 0, 'PaymentRequest.createdGte'
                );
            }
            $this->_createdGte = $dateTime;
        } else {
            throw new InvalidPropertyValueTypeException(
                'Invalid created_gte value type in PaymentsRequest', 0, 'PaymentRequest.createdGte'
            );
        }
    }

    /**
     * Проверяет была ли установлена дата создания от которой выбираются платежи
     * @return bool True если дата была установлена, false если нет
     */
    public function hasCreatedGte()
    {
        return $this->_createdGte !== null;
    }

    /**
     * Возвращает дату создания от которой будут возвращены платежи или null если дата не была установлена
     * @return \DateTime|null Время создания, от (не включая)
     */
    public function getCreatedGt()
    {
        return $this->_createdGt;
    }

    /**
     * Устанавливает дату создания от которой выбираются платежи
     * @param \DateTime|string|int|null $value Время создания, от (не включая) или null чтобы удалить значение
     *
     * @throws InvalidPropertyValueException Генерируется если была передана дата в невалидном формате (была передана
     * строка или число, которые не удалось преобразовать в валидную дату)
     * @throws InvalidPropertyValueTypeException Генерируется если была передана дата с не тем типом (передана не
     * строка, не число и не значение типа \DateTime)
     */
    public function setCreatedGt($value)
    {
        if ($value === null || $value === '') {
            $this->_createdGt = null;
        } elseif (TypeCast::canCastToDateTime($value)) {
            $dateTime = TypeCast::castToDateTime($value);
            if ($dateTime === null) {
                throw new InvalidPropertyValueException(
                    'Invalid created_gt value in PaymentsRequest', 0, 'PaymentRequest.createdGt'
                );
            }
            $this->_createdGt = $dateTime;
        } else {
            throw new InvalidPropertyValueTypeException(
                'Invalid created_gt value type in PaymentsRequest', 0, 'PaymentRequest.createdGt'
            );
        }
    }

    /**
     * Проверяет была ли установлена дата создания от которой выбираются платежи
     * @return bool True если дата была установлена, false если нет
     */
    public function hasCreatedGt()
    {
        return $this->_createdGt !== null;
    }

    /**
     * Возвращает дату создания до которой будут возвращены платежи или null если дата не была установлена
     * @return \DateTime|null Время создания, до (включительно)
     */
    public function getCreatedLte()
    {
        return $this->_createdLte;
    }

    /**
     * Устанавливает дату создания до которой выбираются платежи
     * @param \DateTime|string|int|null $value Время создания, до (включительно) или null чтобы удалить значение
     *
     * @throws InvalidPropertyValueException Генерируется если была передана дата в невалидном формате (была передана
     * строка или число, которые не удалось преобразовать в валидную дату)
     * @throws InvalidPropertyValueTypeException Генерируется если была передана дата с не тем типом (передана не
     * строка, не число и не значение типа \DateTime)
     */
    public function setCreatedLte($value)
    {
        if ($value === null || $value === '') {
            $this->_createdLte = null;
        } elseif (TypeCast::canCastToDateTime($value)) {
            $dateTime = TypeCast::castToDateTime($value);
            if ($dateTime === null) {
                throw new InvalidPropertyValueException(
                    'Invalid created_lte value in PaymentsRequest', 0, 'PaymentRequest.createdLte'
                );
            }
            $this->_createdLte = $dateTime;
        } else {
            throw new InvalidPropertyValueTypeException(
                'Invalid created_lte value type in PaymentsRequest', 0, 'PaymentRequest.createdLte'
            );
        }
    }

    /**
     * Проверяет была ли установлена дата создания до которой выбираются платежи
     * @return bool True если дата была установлена, false если нет
     */
    public function hasCreatedLte()
    {
        return $this->_createdLte !== null;
    }

    /**
     * Возвращает дату создания до которой будут возвращены платежи или null если дата не была установлена
     * @return \DateTime|null Время создания, до (не включая)
     */
    public function getCreatedLt()
    {
        return $this->_createdLt;
    }

    /**
     * Устанавливает дату создания до которой выбираются платежи
     * @param \DateTime|string|int|null $value Время создания, до (не включая) или null чтобы удалить значение
     *
     * @throws InvalidPropertyValueException Генерируется если была передана дата в невалидном формате (была передана
     * строка или число, которые не удалось преобразовать в валидную дату)
     * @throws InvalidPropertyValueTypeException Генерируется если была передана дата с не тем типом (передана не
     * строка, не число и не значение типа \DateTime)
     */
    public function setCreatedLt($value)
    {
        if ($value === null || $value === '') {
            $this->_createdLt = null;
        } elseif (TypeCast::canCastToDateTime($value)) {
            $dateTime = TypeCast::castToDateTime($value);
            if ($dateTime === null) {
                throw new InvalidPropertyValueException(
                    'Invalid created_lt value in PaymentsRequest', 0, 'PaymentRequest.createdLt'
                );
            }
            $this->_createdLt = $dateTime;
        } else {
            throw new InvalidPropertyValueTypeException(
                'Invalid created_lt value type in PaymentsRequest', 0, 'PaymentRequest.createdLt'
            );
        }
    }

    /**
     * Проверяет была ли установлена дата создания до которой выбираются платежи
     * @return bool True если дата была установлена, false если нет
     */
    public function hasCreatedLt()
    {
        return $this->_createdLt !== null;
    }

    /**
     * Возвращает дату проведения от которой будут возвращены платежи или null если дата не была установлена
     * @return \DateTime|null Время проведения операции, от (включительно)
     */
    public function getAuthorizedGte()
    {
        return $this->_authorizedGte;
    }

    /**
     * Устанавливает дату проведения от которой выбираются платежи
     * @param \DateTime|string|int|null $value Время проведения операции, от (не включая) или null чтобы удалить
     * значение
     *
     * @throws InvalidPropertyValueException Генерируется если была передана дата в невалидном формате (была передана
     * строка или число, которые не удалось преобразовать в валидную дату)
     * @throws InvalidPropertyValueTypeException Генерируется если была передана дата с не тем типом (передана не
     * строка, не число и не значение типа \DateTime)
     */
    public function setAuthorizedGte($value)
    {
        if ($value === null || $value === '') {
            $this->_authorizedGte = null;
        } elseif (TypeCast::canCastToDateTime($value)) {
            $dateTime = TypeCast::castToDateTime($value);
            if ($dateTime === null) {
                throw new InvalidPropertyValueException(
                    'Invalid authorized_gte value in PaymentsRequest', 0, 'PaymentRequest.authorizedGte'
                );
            }
            $this->_authorizedGte = $dateTime;
        } else {
            throw new InvalidPropertyValueTypeException(
                'Invalid authorized_gte value type in PaymentsRequest', 0, 'PaymentRequest.authorizedGte'
            );
        }
    }

    /**
     * Проверяет была ли установлена дата проведения от которой выбираются платежи
     * @return bool True если дата была установлена, false если нет
     */
    public function hasAuthorizedGte()
    {
        return $this->_authorizedGte !== null;
    }

    /**
     * Возвращает дату проведения от которой будут возвращены платежи или null если дата не была установлена
     * @return \DateTime|null Время проведения операции, от (не включая)
     */
    public function getAuthorizedGt()
    {
        return $this->_authorizedGt;
    }

    /**
     * Устанавливает дату проведения от которой выбираются платежи
     * @param \DateTime|string|int|null $value Время проведения операции, от (не включая) или null чтобы удалить
     * значение
     *
     * @throws InvalidPropertyValueException Генерируется если была передана дата в невалидном формате (была передана
     * строка или число, которые не удалось преобразовать в валидную дату)
     * @throws InvalidPropertyValueTypeException Генерируется если была передана дата с не тем типом (передана не
     * строка, не число и не значение типа \DateTime)
     */
    public function setAuthorizedGt($value)
    {
        if ($value === null || $value === '') {
            $this->_authorizedGt = null;
        } elseif (TypeCast::canCastToDateTime($value)) {
            $dateTime = TypeCast::castToDateTime($value);
            if ($dateTime === null) {
                throw new InvalidPropertyValueException(
                    'Invalid authorized_gt value in PaymentsRequest', 0, 'PaymentRequest.authorizedGt'
                );
            }
            $this->_authorizedGt = $dateTime;
        } else {
            throw new InvalidPropertyValueTypeException(
                'Invalid authorized_gt value type in PaymentsRequest', 0, 'PaymentRequest.authorizedGt'
            );
        }
    }

    /**
     * Проверяет была ли установлена дата проведения от которой выбираются платежи
     * @return bool True если дата была установлена, false если нет
     */
    public function hasAuthorizedGt()
    {
        return $this->_authorizedGt !== null;
    }

    /**
     * Возвращает дату проведения до которой будут возвращены платежи или null если дата не была установлена
     * @return \DateTime|null Время проведения, до (включительно)
     */
    public function getAuthorizedLte()
    {
        return $this->_authorizedLte;
    }

    /**
     * Устанавливает дату проведения до которой выбираются платежи
     * @param \DateTime|string|int|null $value Время проведения, до (включительно) или null чтобы удалить значение
     *
     * @throws InvalidPropertyValueException Генерируется если была передана дата в невалидном формате (была передана
     * строка или число, которые не удалось преобразовать в валидную дату)
     * @throws InvalidPropertyValueTypeException Генерируется если была передана дата с не тем типом (передана не
     * строка, не число и не значение типа \DateTime)
     */
    public function setAuthorizedLte($value)
    {
        if ($value === null || $value === '') {
            $this->_authorizedLte = null;
        } elseif (TypeCast::canCastToDateTime($value)) {
            $dateTime = TypeCast::castToDateTime($value);
            if ($dateTime === null) {
                throw new InvalidPropertyValueException(
                    'Invalid authorized_lte value in PaymentsRequest', 0, 'PaymentRequest.authorizedLte'
                );
            }
            $this->_authorizedLte = $dateTime;
        } else {
            throw new InvalidPropertyValueTypeException(
                'Invalid authorized_lte value type in PaymentsRequest', 0, 'PaymentRequest.authorizedLte'
            );
        }
    }

    /**
     * Проверяет была ли установлена дата проведения до которой выбираются платежи
     * @return bool True если дата была установлена, false если нет
     */
    public function hasAuthorizedLte()
    {
        return $this->_authorizedLte !== null;
    }

    /**
     * Возвращает дату проведения до которой будут возвращены платежи платежи или null если она не была установлена
     * @return \DateTime|null Время проведения, до (не включая)
     */
    public function getAuthorizedLt()
    {
        return $this->_authorizedLt;
    }

    /**
     * Устанавливает дату проведения до которой выбираются платежи
     * @param \DateTime|string|int|null $value Время проведения, до (не включая) или null чтобы удалить значение
     *
     * @throws InvalidPropertyValueException Генерируется если была передана дата в невалидном формате (была передана
     * строка или число, которые не удалось преобразовать в валидную дату)
     * @throws InvalidPropertyValueTypeException Генерируется если была передана дата с не тем типом (передана не
     * строка, не число и не значение типа \DateTime)
     */
    public function setAuthorizedLt($value)
    {
        if ($value === null || $value === '') {
            $this->_authorizedLt = null;
        } elseif (TypeCast::canCastToDateTime($value)) {
            $dateTime = TypeCast::castToDateTime($value);
            if ($dateTime === null) {
                throw new InvalidPropertyValueException(
                    'Invalid authorized_lt value in PaymentsRequest', 0, 'PaymentRequest.authorizedLt'
                );
            }
            $this->_authorizedLt = $dateTime;
        } else {
            throw new InvalidPropertyValueTypeException(
                'Invalid authorized_lt value type in PaymentsRequest', 0, 'PaymentRequest.authorizedLt'
            );
        }
    }

    /**
     * Проверяет была ли установлена дата проведения до которой выбираются платежи
     * @return bool True если дата была установлена, false если нет
     */
    public function hasAuthorizedLt()
    {
        return $this->_authorizedLt !== null;
    }

    /**
     * Возвращает статус выбираемых платежей или null если он до этого не был установлен
     * @return string|null Статус выбираемых платежей
     */
    public function getStatus()
    {
        return $this->_status;
    }

    /**
     * Устанавливает статус выбираемых платежей
     * @param string $value Статус выбираемых платежей или null чтобы удалить значение
     *
     * @throws InvalidPropertyValueException Выбрасывается если переданное значение не является валидным статусом
     * @throws InvalidPropertyValueTypeException Выбрасывается если в метод была передана не строка
     */
    public function setStatus($value)
    {
        if ($value === null || $value === '') {
            $this->_status = null;
        } elseif (TypeCast::canCastToEnumString($value)) {
            if (!Status::valueExists((string)$value)) {
                throw new InvalidPropertyValueException(
                    'Invalid status value in PaymentsRequest', 0, 'PaymentsRequest.status', $value
                );
            } else {
                $this->_status = (string)$value;
            }
        } else {
            throw new InvalidPropertyValueTypeException(
                'Invalid status value in PaymentsRequest', 0, 'PaymentsRequest.status', $value
            );
        }
    }

    /**
     * Проверяет был ли установлен статус выбираемых платежей
     * @return bool True если статус был установлен, false если нет
     */
    public function hasStatus()
    {
        return $this->_status !== null;
    }

    /**
     * Возвращает токен для получения следующей страницы выборки
     * @return string|null Токен для получения следующей страницы выборки
     */
    public function getNextPage()
    {
        return $this->_nextPage;
    }

    /**
     * Устанавливает токен следующей страницы выборки
     * @param string $value Токен следующей страницы выборки или null чтобы удалить значение
     *
     * @throws InvalidPropertyValueTypeException Выбрасывается если в метод была передана не строка
     */
    public function setNextPage($value)
    {
        if ($value === null || $value === '') {
            $this->_nextPage = null;
        } elseif (TypeCast::canCastToString($value)) {
            $this->_nextPage = (string)$value;
        } else {
            throw new InvalidPropertyValueTypeException(
                'Invalid status value in PaymentsRequest', 0, 'PaymentsRequest.status', $value
            );
        }
    }

    /**
     * Проверяет был ли установлен токен следующей страницы
     * @return bool True если токен был установлен, false если нет
     */
    public function hasNextPage()
    {
        return $this->_nextPage !== null;
    }

    /**
     * Проверяет валидность текущего объекта запроса
     * @return bool True если объект валиден, false если нет
     */
    public function validate()
    {
        if (empty($this->_accountId)) {
            $this->setValidationError('Shop id not specified');
            return false;
        }
        return true;
    }
}
