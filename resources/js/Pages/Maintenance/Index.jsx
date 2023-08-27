import { PlusOutlined } from '@ant-design/icons';
import { Button, Space, Select, Input, Row, Col } from 'antd';
import { Link, usePage, router } from '@inertiajs/react'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import InProgress from './Partials/InProgress';
import Historic from './Partials/Historic';
import React, { useState } from 'react';


const Index = ({ vehicleUser, f_maintenance, p_maintenance, filters, t_progress }) => {

    const { permissions } = usePage().props?.auth || [];
    const { data } = p_maintenance;
    const [searchValue, setSearchValue] = useState('');
    const [searchKeyValue, setSearchKeyValue] = useState(filters.key || 'plate');
    const [filterItemValue, setFilterItemValue] = useState(filters.filter || 'all');
    const [searchItemValue, setSearchItemValue] = useState({
        label: 'Placa',
        value: 'plate',
    });

    const options = [
        {
            label: 'Placa',
            value: 'plate'
        }, {
            label: 'Identificación',
            value: 'identification'
        },
    ];

    const optionState = [
        {
            label: 'Todos',
            value: 'all'
        },{
            label: 'Solicitud Enviada',
            value: "cero"
        }, {
            label: 'Solicitud Rechazada',
            value: "1"
        }, {
            label: 'En Mantenimiento',
            value: "2"
        }, {
            label: 'En Entrega',
            value: "3"
        }, {
            label: 'Finalizado',
            value: "4"
        }
    ];


    const handleSeach = (value, itemValue) => {
        const iValue = itemValue.value || itemValue;
        setSearchKeyValue(iValue);
        router.visit(route('maintenance.index', { value: value, key: iValue, filter:filterItemValue }), {
            preserveState: true,
            method: 'get'
        })
    };

    const handleFilter = (e) => {
        setFilterItemValue(e);
        router.visit(route('maintenance.index', { filter: e, value: searchValue, key: searchKeyValue}), {
            preserveState: true,
            preserveScroll: true,
            replace: true,
            method: 'get'
        })
    }


    return (
        <>
            <div className='flex justify-end mb-4'>
                {
                    (t_progress === 0) && (vehicleUser.length > 0) && permissions.includes('maintenance.create') && (
                        <>
                            <Link href={route('maintenance.create')}>
                                <Button
                                    type="primary"
                                    size="large"
                                    className="bg-[#52c41a] hover:bg-blue-100"
                                    icon={<PlusOutlined />}
                                >
                                    Mantenimiento
                                </Button>
                            </Link>
                        </>
                    )
                }
                {
                    (vehicleUser.length === 0) && permissions.includes('maintenance.create') && (
                        <>
                            <Link href={route('maintenance.request')}>
                                <Button
                                    type="primary"
                                    size="large"
                                    className="bg-[#52c41a] hover:bg-blue-100"
                                    icon={<PlusOutlined />}
                                >
                                    Solicitar Vehículo
                                </Button>
                            </Link>
                        </>
                    )
                }

            </div>
            <Row
                justify='end'
                align='middle'
                gutter={[12, 12]}
            >
                <Col
                    span={24}
                    align='end'
                >
                    <Space.Compact size='large'>
                        <Select
                            options={options}
                            defaultValue={options[0]}
                            onChange={value => setSearchItemValue(value)}
                        />
                        <Input.Search
                            value={searchValue}
                            onChange={e => setSearchValue(e.target.value)}
                            onSearch={value => handleSeach(value, searchItemValue)}
                        />
                    </Space.Compact>
                </Col>
                <Col
                    span={24}
                    align='end'
                >
                    <Select
                        options={optionState}
                        defaultValue={optionState[0]}
                        onChange={value => handleFilter(value)}
                    />
                </Col>
            </Row>


            <div className="mt-0">
                <InProgress
                    progressData={p_maintenance}
                ></InProgress>
            </div>
            <div className="mt-12 ">
                <Historic
                    historicData={f_maintenance}
                ></Historic>
            </div>
        </>

    );
}

Index.layout = page => (<AuthenticatedLayout title="Mantenimientos" children={page} />)


export default Index
