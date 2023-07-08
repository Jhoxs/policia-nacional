import { Card, Row, Col, Button, Statistic, message, Popconfirm, App, Typography, Tooltip } from 'antd';
import { QuestionCircleOutlined, PlusOutlined } from '@ant-design/icons';
import { EnvironmentOutlined, EyeOutlined, OrderedListOutlined } from '@ant-design/icons';
import { useState } from 'react';
import { usePage, router, Link } from '@inertiajs/react';

import DCard from './DCard';

const { Title } = Typography;

const DependenceList = ({ dependeces }) => {
    const { permissions } = usePage().props?.auth || [];

    const { d_cities, d_subcircuits, d_circuits, d_provinces} = dependeces;

    return (
        <>
            <div className="flex items-center mt-2 mb-4">
                <Title level={2} ellipsis>
                    Dependencias
                </Title>
                <h1 className="flex-1 border-b-2 border-gray-100"></h1>
            </div>
            <Row gutter={[16, 24]}>
                <Col xl={6} lg={8} md={12} sm={20} xs={24}>
                    <DCard
                        propCard={d_provinces}
                        propLinks={{
                            showLink: 'province.index',
                            editLink: 'province.index'
                        }}
                    />
                </Col>
                <Col xl={6} lg={8} md={12} sm={20} xs={24}>
                    <DCard
                        propCard={d_cities}
                        propLinks={{
                            showLink: 'city.index',
                            editLink: 'city.index'
                        }}
                    />
                </Col>
                <Col xl={6} lg={8} md={12} sm={20} xs={24}>
                    <DCard
                        propCard={d_circuits}
                        propLinks={{
                            showLink: 'circuit.index',
                            editLink: 'circuit.index'
                        }}
                    />
                </Col>
                <Col xl={6} lg={8} md={12} sm={20} xs={24}>
                    <DCard
                        propCard={d_subcircuits}
                        propLinks={{
                            showLink: 'subcircuit.index',
                            editLink: 'subcircuit.index'
                        }}
                    />
                </Col>
            </Row>
        </>
    );
}


export default DependenceList